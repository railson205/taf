<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exercicios_usuarios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notas_exercicios_model');
    }

    public function listar_exercicios_usuarios()
    {
        $dados = $this->db
            ->select('
            u.id as usuario_id,
        u.nome,
        u.sexo,
        u.data_nascimento,
        CONCAT(f.idade_inicial,"-",f.idade_final) AS faixa_etaria,
        f.nome_grupo as grupo_faixa_etaria,
        re.id as exercicio_id,
        re.nome_exercicio,
        re.tipo_exercicio,
        eu.contagem_exercicio,
    ')
            ->from('exercicios_usuarios eu')
            ->join('usuarios u', 'u.id = eu.usuario_id')
            ->join('registro_exercicios re', 're.id = eu.registro_exercicio_id')
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

    public function inserir_exercicios_usuarios($dados)
    {
        $existe = $this->db->from('exercicios_usuarios')->where('usuario_id', $dados['usuario_id'])->where('registro_exercicio_id', $dados['registro_exercicio_id'])->get('')->row_array();
        if (!$existe) {
            $this->db->insert('exercicios_usuarios', $dados);
            return $this->db->insert_id();
        } else if ($existe['contagem_exercicio'] != $dados['contagem_exercicio']) {
            $this->db->where('id', $existe['id'])->update('exercicios_usuarios', ['contagem_exercicio' => $dados['contagem_exercicio']]);
            return $existe['id'];
        } else
            return $existe['id'];
    }


}
?>