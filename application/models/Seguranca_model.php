<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seguranca_model extends CI_Model
{
    public function __construct()
    {
        $this->nome_tabela = 'seguranca';
    }

    public function efetuar_login($data)
    {

        $dados = $this->db->select('s.id,s.email,s.nivel,s.usuario_id,u.nome,s.senha')->from($this->nome_tabela . ' s')->join('usuarios u', 'u.id=s.usuario_id')->where('s.email', $data['email'])->get()->row_array();
        $senha = $this->db
            ->select('senha')
            ->from($this->nome_tabela)
            ->where('email', $data['email'])
            ->get()
            ->row()
            ->senha ?? null;

        return password_verify($data['senha'], $senha) ? $dados : null;
    }

    public function listar_logins()
    {
        return $this->db->select('s.id,s.email,s.nivel,s.usuario_id,u.nome,u.matricula,u.data_nascimento,u.sexo')->from($this->nome_tabela . ' s')->join('usuarios u', 'u.id=s.usuario_id')->get()->result_array();
    }

    public function getUserByEmail($email)
    {
        return $this->db->select('s.id,s.email,s.nivel,s.usuario_id,u.nome,u.matricula,u.data_nascimento,u.sexo')->from($this->nome_tabela . ' s')->join('usuarios u', 'u.id=s.usuario_id')->where('s.email', $email)->get()->row_array();
    }

    public function getIdByUsuarioId($uid)
    {
        return $this->db->select('id')->from($this->nome_tabela)->where('usuario_id', $uid)->get()->row()->id ?? null;
    }

    public function getEmailById($id)
    {
        return $this->db->select('email')->from($this->nome_tabela)->where('id', $id)->get()->row()->email ?? null;
    }

    public function getNomeById($id)
    {
        $uid = $this->db->select('usuario_id')->from($this->nome_tabela)->where('id', $id)->get()->row()->usuario_id ?? null;
        return $this->Usuarios_model->getNomeById($uid);
    }

    public function adicionar_login($data)
    {
        $email_existe = $this->db->where('email', $data['email'])->get($this->nome_tabela)->row_array();
        $cadastro_existe = $this->db->where('usuario_id', $data['usuario_id'])->get($this->nome_tabela)->row_array();
        if ($email_existe) {
            return [
                'status' => false,
                'message' => 'Email ja cadastrado',
                'type' => 'danger'
            ];
        } elseif ($cadastro_existe) {
            return [
                'status' => false,
                'message' => 'Usuario ja cadastrado',
                'type' => 'danger'
            ];
        } else {
            $this->db->insert($this->nome_tabela, $data);
            return [
                'status' => $this->db->affected_rows() > 0,
                'message' => 'Login cadastrado.',
                'type' => 'success'
            ];
        }
    }

    public function editar_login($id, $data)
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

    public function excluir_login($id)
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

    public function redefinirSenha($email, $senhaHash)
    {
        $this->db->where('email', $email)->update($this->nome_tabela, ['senha' => $senhaHash]);
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
}
?>