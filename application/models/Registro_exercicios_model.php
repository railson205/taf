<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro_exercicios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Idades_model');
    }

    public function listar_exercicios()
    {
        $dados = $this->db
            ->select('
            re.id as exercicio_id,
        re.nome_exercicio,
        re.tipo_exercicio
    ')
            ->from('registro_exercicios re')
            ->order_by('re.nome_exercicio')
            ->get()
            ->result_array();
        return $dados;
    }

    public function inserir_registro_exercicio($dados)
    {

        return $this->db->insert('registro_exercicios', $dados);
    }

}
?>