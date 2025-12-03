<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EsqueceuSenha extends CI_Controller
{
    public function index()
    {


        $data = [
            'title' => 'Esqueceu a senha',
            'view_name' => 'esqueceuSenhaView',
            'view_data' => []
        ];
        $this->load->view('templates/layout', $data);

    }

    public function enviarEmailRecuperacao()
    {
        $emailDestino = $this->input->post('email');
        $usuario = $this->Seguranca_model->getUserByEmail($emailDestino);

        if (!$usuario) {
            redirect('EsqueceuSenha');
        }

        $this->load->library('email');

        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'testetaf73@gmail.com',
            'smtp_pass' => 'kdrc txys aesg ijsm',
            'smtp_crypto' => 'tls',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
        ];

        $this->email->initialize($config);

        $this->email->from('testetaf73@gmail.com', 'Sistema CBMCE');

        $this->email->to($emailDestino);

        $this->email->subject('Recuperar Senha');

        $token = $this->gerarTokenRecuperação($emailDestino);
        $link = site_url("EsqueceuSenha/redefinirSenha/$token");

        $this->email->message("
        <p>Olá, <strong>{$usuario['nome']}</strong></p>
        <p>Para redefinir sua senha, clique no link abaixo:</p>
        <p><a href='{$link}'>Redefinir minha senha</a></p>
    ");

        $this->email->send();
        $this->session->set_flashdata('alert_type', 'success');
        $this->session->set_flashdata('alert_message', 'Verfique seu email');
        redirect('/');
    }

    public function gerarTokenRecuperação($emailDestino)
    {
        $token = bin2hex(random_bytes(16));
        $tokenHash = hash('sha256', $token);

        $expiresAt = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

        $data = [
            'email' => $emailDestino,
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt
        ];

        $this->Recuperacao_senhas_model->adicionar_token($data);
        return $token;
    }

    public function redefinirSenha($token = null)
    {

        if (!$token) {
            show_error('Token inválido', 400);
        }
        $tokenHash = hash('sha256', $token);

        $tokenIsValid = $this->Recuperacao_senhas_model->getToken($tokenHash);

        if (!$tokenIsValid) {
            // token inválido/expirado/usado
            $this->session->set_flashdata('alert_type', 'error');
            $this->session->set_flashdata('alert_message', 'Token inválido ou expirado.');
            redirect('Login'); // ou mostrar view de erro
            return;
        }

        $this->session->set_userdata('token', $token);
        $this->session->set_userdata('email', $tokenIsValid->email);
        redirect('RedefinirSenha');
    }


}