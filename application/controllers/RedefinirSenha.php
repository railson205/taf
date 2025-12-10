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
    }


}