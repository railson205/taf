<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
    public function __construct()
    {
        $this->nome_tabela = 'usuarios';
    }

    public function listar_usuarios()
    {
        $dados = $this->db->select('id,nome,sexo,data_de_nascimento,matricula')->from($this->nome_tabela)->order_by('nome, data_de_nascimento')->get()->result_array();
        return $dados;
    }

    public function getNomeById($uid)
    {
        return $this->db->select('nome')->from($this->nome_tabela)->where('id', $uid)->get()->row()->nome ?? null;
    }

    public function inserir_usuario($data)
    {
        $matricula_existe = $this->db->where('matricula', $data['matricula'])->get($this->nome_tabela)->row_array();
        if ($matricula_existe) {
            return [
                'status' => false,
                'message' => 'Matrícula ja cadastrada.',
                'type' => 'error'
            ];
        }
        $this->db->insert($this->nome_tabela, $data);
        return [
            'status' => $this->db->affected_rows() > 0,
            'message' => 'Usuário cadastrado.',
            'type' => 'success'
        ];
    }

    public function editar_usuario($id, $data)
    {
        $this->db->where('id', $id)->update($this->nome_tabela, $data);

        if ($this->db->affected_rows() > 0) {
            return [
                'status' => true,
                'message' => 'Edição bem-sucedida.',
                'type' => 'success'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Nenhuma alteração detectada.',
                'type' => 'warning'
            ];
        }
    }

    public function excluir_usuario($id)
    {
        $this->db->where('id', $id)->delete($this->nome_tabela);

        if ($this->db->affected_rows() > 0) {
            return [
                'status' => true,
                'message' => 'Resultado excluído com sucesso.',
                'type' => 'success'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Falha ao excluir resultado (ID inexistente).',
                'type' => 'error'
            ];
        }
    }

}
?>