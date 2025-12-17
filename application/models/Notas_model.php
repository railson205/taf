<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notas_model extends CI_Model
{

    public function __construct()
    {
        $this->nome_tabela = 'notas';
        parent::__construct();
        $this->load->model('Exercicios_model');
    }

    public function listar_notas()
    {
        $dados = $this->db
            ->select('
        n.id,
        CONCAT(f.idade_inicial,"-",f.idade_final) AS faixa_etaria,
        f.nome_grupo as grupo_faixa_etaria,
        n.sexo,
        n.valor_nota,
        e.id as exercicio_id,
        e.nome_exercicio,
        e.modo_contagem,
        n.indice,
        f.id as faixa_id,
    ')
            ->from($this->nome_tabela . ' n')
            ->join('faixas_etarias f', 'f.id = n.faixa_id')
            ->join('exercicios e', 'e.id = n.exercicio_id')
            ->order_by('n.valor_nota', 'faixa_etaria', 'n.sexo')
            ->get()
            ->result_array();

        return $dados;
    }

    function listar_notas_para_resultados()
    {
        $dados = $this->db
            ->select('
            n.id,
            n.indice,
            n.sexo,
            n.exercicio_id,
            f.id as faixa_id,
            e.modo_contagem,
            n.valor_nota,
    ')
            ->from($this->nome_tabela . ' n')
            ->join('faixas_etarias f', 'f.id = n.faixa_id')
            ->join('exercicios e', 'e.id = n.exercicio_id')
            ->order_by('n.valor_nota', 'faixa_etaria', 'n.sexo')
            ->get()
            ->result_array();

        return $dados;
    }

    public function getNotasById($id){
        return $this->db->from($this->nome_tabela)->where('id',$id)->get()->row_array();
    }

    function inserir_nova_nota($data)
    {
        // Condições de unicidade em um único where()
        $condicoes = [
            'faixa_id' => $data['faixa_id'],
            'sexo' => $data['sexo'],
            'exercicio_id' => $data['exercicio_id'],
            'indice' => $data['indice']
        ];

        // Verifica se já existe
        $nota_existe = $this->db->where($condicoes)->get($this->nome_tabela)->row_array();

        if ($nota_existe) {
            return [
                'status' => false,
                'message' => 'Exercício já cadastrado.',
                'type' => 'error'
            ];
        }

        // Insere nova nota
        $this->db->insert($this->nome_tabela, $data);

        return [
            'status' => $this->db->affected_rows() > 0,
            'message' => 'Exercício cadastrado com sucesso.',
            'type' => 'success'
        ];
    }


    function editar_notas($id, $data)
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
                'message' => 'nnhuma alteração detectada.',
                'type' => 'warning'
            ];
        }
    }

    function excluir_notas($id)
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
                'message' => 'Falha ao excluir resultado (ID inxistente).',
                'type' => 'error'
            ];
        }
    }

}
?>