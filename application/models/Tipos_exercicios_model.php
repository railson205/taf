<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tipos_exercicios_model extends CI_Model
{

    public function listar_exercicios()
    {
        $dados = $this->db
            ->select('
            re.id as exercicio_id,
        re.nome_exercicio,
        re.modo_contagem
    ')
            ->from('tipos_exercicios re')
            ->order_by('re.nome_exercicio')
            ->get()
            ->result_array();
        return $dados;
    }

    public function inserir_registro_exercicio($dados)
    {
        return $this->db->insert('tipos_exercicios', $dados);
    }

}
?>