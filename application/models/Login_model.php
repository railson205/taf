<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function __construct()
    {
        $this->nome_tabela = 'usuarios';
    }

    public function efetuar_login($data)
    {
        return $this->db->where('nome', $data['nome'])->where('senha', $data['senha'])->get($this->nome_tabela)->row_array();
    }


}
?>