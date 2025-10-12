<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exercicios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Carrega o outro model
        $this->load->model('Idade_model');
    }

    public function listar_exercicios()
    {
        $dados = $this->db->select('
                u.nome, 
                f.id as faixa_id,
                u.sexo,
                r.corrida_2400m, 
                r.flexao_abdominal_supra, 
                r.flexao_barra_fixa, 
                r.natacao_100m, 
                r.flexao_braco_solo, 
                r.natacao_12min,
                r.id,
                u.id as usuario_id
            ')
            ->from('exercicios_usuarios r')
            ->join('usuarios u', 'u.id = r.usuario_id')
            ->join('faixas_etarias f', 'f.id = r.faixa_id')
            ->get()
            ->result_array();
        foreach ($dados as $value => $row) {
            $row['faixa'] = $this->Idade_model->get_faixa_by_id($row['faixa_id']);
            $row['corrida_2400m'] = segundos_para_tempo($row['corrida_2400m']);
            $row['natacao_100m'] = segundos_para_tempo($row['natacao_100m']);
            $dados[$value] = $row;
        }
        return $dados;
    }

    public function inserir_exercicios($dados)
    {
        //Help:Insere um novo usuário na tabela 'usuarios' com os dados fornecidos
        return $this->db->insert('exercicios_usuarios', $dados);
    }

}
?>