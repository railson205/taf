<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Idades_model extends CI_Model
{

    public function listar_faixa_etaria()
    {
        $dados = $this->db->select('
        f.id,
        f.nome_grupo,
        f.idade_inicial,
        f.idade_final,
        CONCAT(f.idade_inicial,"-",f.idade_final) AS faixa_etaria,
        ')
            ->from('faixas_etarias f')
            ->order_by('f.idade_inicial')
            ->get()
            ->result_array();
        return $dados;
    }

    public function inserir_faixa_etaria($data)
    {
        return $this->db->insert('faixas_etarias', $data);
    }

    public function get_faixa_etaria($data_nascimento)
    {
        $d_nasc = new DateTime($data_nascimento);
        $idade = ((new DateTime())->diff($d_nasc)->y) - 1;

        $this->db->where('idade_inicial <=', $idade);
        $this->db->where('idade_final >=', $idade);
        return $this->db->get('faixas_etarias')->row_array();
    }

    public function get_faixa_by_id($id)
    {
        $faixa = $this->db->get_where('faixas_etarias', ['id' => $id])->row_array();
        return strval($faixa['idade_inicial']) . '-' . strval($faixa['idade_final']);
    }

    public function get_id_by_faixa($data_nascimento)
    {
        $d_nasc = new DateTime($data_nascimento);
        $idade = ((new DateTime())->diff($d_nasc)->y) - 1;

        $this->db->where('idade_inicial <=', $idade);
        $this->db->where('idade_final >=', $idade);
        $row = $this->db->get('faixas_etarias')->row_array();
        return $row['id'];
    }

}
?>