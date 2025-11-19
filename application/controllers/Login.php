<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Se quiser, pode mudar o layout padrão aqui:
        $this->layout = 'templates/layouts/semUsuario';
    }

    public function index()
    {
        $data = [
            'title' => 'Login',
            'view_name' => 'loginView',
            'view_data' => []
        ];
        $this->load->view('templates/layout', $data);
    }

    public function efetuar_login()
    {
        $data = [
            'email' => $this->input->post('email'),
            'senha' => $this->input->post('senha'),
        ];
        $this->session->set_userdata('usuario', $this->Login_model->efetuar_login($data));
        redirect('/');
    }

    public function logout(){
        $this->session->set_userdata('usuario','');
        redirect('/');
    }
}
