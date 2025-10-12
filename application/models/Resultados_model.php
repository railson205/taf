<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resultados_model extends CI_Model
{

    public function get_resultados()
    {
        $dados = $this->session->userdata('resultados');
        return $dados;
    }
    public function listar_resultados()
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
                r.nota_total,
                r.id
            ')
            ->from('resultados_usuarios r')
            ->join('usuarios u', 'u.id = r.usuario_id')
            ->join('faixas_etarias f', 'f.id = r.faixa_id')
            ->get()
            ->result_array();
        foreach ($dados as $value => $row) {
            $row['faixa'] = $this->Idade_model->get_faixa_by_id($row['faixa_id']);
            $dados[$value] = $row;
        }
        return $dados;
    }

    public function inserir_dados($dados)
{
    $this->db->where('usuario_id', $dados['usuario_id']);
    $this->db->where('faixa_id', $dados['faixa_id']);
    $query = $this->db->get('resultados_usuarios');

    if ($query->num_rows() > 0) {
        // Atualiza se já existir
        $this->db->where('usuario_id', $dados['usuario_id']);
        $this->db->where('faixa_id', $dados['faixa_id']);
        return $this->db->update('resultados_usuarios', $dados);
    } else {
        // Caso contrário, insere
        return $this->db->insert('resultados_usuarios', $dados);
    }
}


}
?>