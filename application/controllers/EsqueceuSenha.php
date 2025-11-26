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

    public function enviar_email(){
        $email=$this->input->post('email');
        //Help: usar o email recebido aqui para enviar um email de recuperação de senha
    }

}