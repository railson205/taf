<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recuperacao_senhas_model extends CI_Model
{

    public function __construct()
    {
        $this->nome_tabela = 'recuperacao_senhas';
    }
    public function adicionar_token($data)
    {
        return $this->db->insert($this->nome_tabela, $data);
    }

    public function getToken($tokenHash)
    {
        $this->db->where('token_hash', $tokenHash);
        $this->db->where('used', 0);
        $this->db->where('expires_at >=', date('Y-m-d H:i:s'));
        return $this->db->get('recuperacao_senhas')->row();
    }

    public function invalidaToken($tokenHash)
    {
        return $this->db->where('token_hash', $tokenHash)->update($this->nome_tabela, ['used' => 1]);
    }
}