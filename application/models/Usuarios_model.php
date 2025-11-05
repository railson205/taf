<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{

    public function buscar($usuario_id)
    {
        return $this->db->get_where('usuarios', ['id' => $usuario_id])->row_array();
    }

    public function listar_todos_usuarios()
    {
        $dados = $this->db->select('u.id,u.nome,u.sexo,u.data_nascimento')->from('usuarios u')->order_by('u.nome, u.data_nascimento')->get()->result_array();
        return $dados;
    }

    public function inserir_usuario($data)
    {
        return $this->db->insert('usuarios', $data);
    }

}
?>