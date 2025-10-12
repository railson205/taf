<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends CI_Model
{

    public function buscar($usuario_id)
    {
        return $this->db->get_where('usuarios', ['id' => $usuario_id])->row_array();
    }

    public function listar_todos_usuarios()
    {
        return $this->db->get('usuarios')->result_array();
    }

    public function inserir_usuario($nome, $data_nascimento, $sexo)
    {
        //Help:Insere um novo usuário na tabela 'usuarios' com os dados fornecidos
        $data = [
            'nome' => $nome,
            'data_nascimento' => $data_nascimento,
            'sexo' => $sexo
        ];
        return $this->db->insert('usuarios', $data);
    }

}
?>