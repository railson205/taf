<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Idade_model extends CI_Model
{

    public function listar_faixa_etaria()
    {
        $dados = $this->db->get('faixas_etarias')->result_array();
        foreach ($dados as $value => $row) {
            $row['faixa'] = $this->Idade_model->get_faixa_by_id($row['id']);
            $dados[$value] = $row;
        }
        return $dados;
    }

    public function inserir_faixa_etaria($idade_i, $idade_f)
    {
        //Help:Insere um novo usuário na tabela 'usuarios' com os dados fornecidos
        $data = [
            'idade_inicial' => $idade_i,
            'idade_final' => $idade_f
        ];
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

    public function get_id_by_faixa($ii, $if)
    {
        $faixa = $this->db->get_where('faixas_etarias', ['idade_inicial' => $ii, 'idade_final' => $if])->row_array();
        return $faixa['id'];
    }

}
?>