<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log_model extends CI_Model
{

    public function __construct()
    {
        $this->nome_tabela = 'log_avaliacao';
        parent::__construct();
    }

    public function inserirLog($data)
    {
        return $this->db->insert($this->nome_tabela, $data);
    }

    public function atualizarLog()
    {
        

    }

}
?>