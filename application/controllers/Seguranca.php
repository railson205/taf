<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seguranca extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Segurança',
            'view_name' => 'segurancaView',
            'view_data' => ['logins' => $this->Login_model->listar_logins()]
        ];
        $this->load->view('templates/layout', $data);
    }

    function adicionar_login()
    {
        $data = [
        ];
        $resultado=$this->Login_model->adicionar_login($data);
        
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);
        
        redirect('FaixasEtarias');
    }

    function editar_login()
    {
        $id= $this->input->post('login_id_edicao');
        $data = [
        ];
        $resultado=$this->Login_model->editar_login($id, $data);
        
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);
        
        redirect('FaixasEtarias');
    }

    function excluir_login()
    {
        $id= $this->input->post('login_id_excluir');
        
        $resultado=$this->Login_model->excluir_login($id);
        
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);
        
        redirect('FaixasEtarias');
    }
}