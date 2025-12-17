<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log_model extends CI_Model
{

    public function __construct()
    {
        $this->nome_tabela = 'log_avaliacao';
        parent::__construct();
    }

    public function getInfoByResultadoId($resultado_id)
    {
        return $this->db->where('resultado_id', $resultado_id)->from($this->nome_tabela)->order_by('atualizado_em', 'DESC')->get()->result_array();
    }

    public function inserirLog($data, $id)
    {
        $data['resultado_id'] = $id;
        $this->db->insert($this->nome_tabela, $data);
        return $this->db->insert_id();
    }

    public function atualizarLog($resultado_id, $indice_id)
    {
        //Coleta a row para poder modificar os valores
        $data = $this->db->where('resultado_id', $resultado_id)->from($this->nome_tabela)->get()->row_array();
        $data['indice_id'] = $indice_id;
        //Retira os dados de modificado para pegar o valor ao adicionar e id para não ter duplicata
        unset($data['atualizado_em']);
        unset($data['id']);
        $this->db->insert($this->nome_tabela, $data);
    }

}
?>