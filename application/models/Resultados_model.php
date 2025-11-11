<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resultados_model extends CI_Model
{
    public function __construct()
    {
        $this->nome_tabela = 'resultados';
        parent::__construct();
        $this->load->model('Notas_model');
    }

    public function listar_resultados()
    {
        $dados = $this->db
            ->select('
        r.id,
        u.id as usuario_id,
        u.nome,
        u.sexo,
        u.data_nascimento,
        CONCAT(f.idade_inicial,"-",f.idade_final) AS faixa_etaria,
        f.nome_grupo as grupo_faixa_etaria,
        e.id as exercicio_id,
        e.nome_exercicio,
        e.modo_contagem,
        n.indice,
        n.valor_nota,
        n.id as nota_id
    ')
            ->from($this->nome_tabela . ' r')
            ->join('usuarios u', 'u.id = r.usuario_id')
            ->join('exercicios e', 'e.id = r.exercicio_id')
            ->join('notas n', 'n.id=r.nota_id')
            ->join(
                'faixas_etarias f',
                'TIMESTAMPDIFF(YEAR, u.data_nascimento, DATE(CONCAT(YEAR(CURDATE())-1, "-12-31"))) 
         BETWEEN f.idade_inicial AND f.idade_final'
            )
            ->order_by('u.nome, u.data_nascimento')
            ->get()
            ->result_array();

        return agrupar_exercicios_por_usuarios($dados);
    }

    function inserir_resultados($dados)
    {
        // Verifica duplicidade
        $existe = $this->db
            ->where('usuario_id', $dados['usuario_id'])
            ->where('exercicio_id', $dados['exercicio_id'])
            ->get($this->nome_tabela)
            ->row_array();

        if ($existe) {
            return [
                'status' => false,
                'message' => 'Exercício já contabilizado.',
                'type' => 'danger'
            ];
        }

        $this->db->insert($this->nome_tabela, $dados);

        return [
            'status' => $this->db->affected_rows() > 0,
            'message' => 'Resultado inserido com sucesso!',
            'type' => 'success'
        ];
    }

    function editar_resultados($id, $data)
    {
        $this->db->where('id', $id)->update($this->nome_tabela, $data);

        if ($this->db->affected_rows() > 0) {
            return [
                'status' => true,
                'message' => 'Edição bem-sucedida.',
                'type' => 'success'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Nenhuma alteração detectada.',
                'type' => 'warning'
            ];
        }
    }

    function excluir_resultados($id)
    {
        $this->db->where('id', $id)->delete($this->nome_tabela);

        if ($this->db->affected_rows() > 0) {
            return [
                'status' => true,
                'message' => 'Resultado excluído com sucesso.',
                'type' => 'success'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Falha ao excluir resultado (ID inexistente).',
                'type' => 'danger'
            ];
        }
    }

}
?>