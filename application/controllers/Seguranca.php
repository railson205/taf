<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seguranca extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Segurança',
            'view_name' => 'segurancaView',
            'view_data' => ['logins' => $this->Seguranca_model->listar_logins(), 'usuarios' => $this->Usuarios_model->listar_usuarios(),]
        ];
        $this->load->view('templates/layout', $data);
    }

    function adicionar_login()
    {
        $data = [
            'email' => $this->input->post('email'),
            'senha' => $this->input->post('senha'),
            'nivel' => $this->input->post('nivel'),
            'usuario_id' => $this->input->post('usuario_id'),
        ];
        $resultado = $this->Seguranca_model->adicionar_login($data);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Seguranca');
    }

    function editar_login()
    {
        $id = $this->input->post('seguranca_id_editar');
        $data = [
            'email' => $this->input->post('seguranca_email_editar'),
            'nivel' => $this->input->post('seguranca_nivel_editar'),
        ];
        $resultado = $this->Seguranca_model->editar_login($id, $data);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Seguranca');
    }

    function excluir_login()
    {
        $id = $this->input->post('seguranca_id_excluir');

        $resultado = $this->Seguranca_model->excluir_login($id);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Seguranca');
    }

    
}