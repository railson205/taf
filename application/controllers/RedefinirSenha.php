<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RedefinirSenha extends CI_Controller
{
    public function index()
    {

        $data = [
            'title' => 'Redefinir a senha',
            'view_name' => 'redefinirSenhaView',
            'view_data' => []
        ];
        $this->load->view('templates/layout', $data);

    }

    public function salvarNovaSenha()
    {
        $tokenHash = $_SESSION['token'];
        $emailDestino = $_SESSION['email'];
        debug($tokenHash);
        $senha = $this->input->post('senha');
        $senhaConfirmacao = $this->input->post('senhaConfirmacao');

        if ($senha != $senhaConfirmacao) {
            //Help: Modificar para mostrar alert
            return;
        }

        $novaSenhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $this->Recuperacao_senhas_model->invalidaToken($tokenHash);
        $this->Seguranca_model->redefinirSenha($emailDestino,$novaSenhaHash);
        redirect('Login');
        /*$rawToken = $this->input->post('token');
        $novaSenha = $this->input->post('senha');

        $tokenHash = hash('sha256', $rawToken);

        // recuperar token válido
        $this->db->where('token_hash', $tokenHash);
        $this->db->where('used', 0);
        $this->db->where('expires_at >=', date('Y-m-d H:i:s'));
        $row = $this->db->get('recuperacao_senhas')->row();

        if (!$row) {
            // token inválido
            $this->session->set_flashdata('alert_message', 'Token inválido ou expirado.');
            redirect('Login');
            return;
        }

        // atualizar senha do usuário (assumindo tabela usuarios com campo email)
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $this->db->where('email', $row->email);
        $this->db->update('usuarios', ['senha' => $senhaHash]);

        // marcar token como usado
        $this->db->where('id', $row->id);
        $this->db->update('recuperacao_senhas', ['used' => 1]);

        $this->session->set_flashdata('alert_message', 'Senha redefinida com sucesso.');
        redirect('Login');*/
    }


}