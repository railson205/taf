<?php

class Usuarios extends CI_Controller
{
    public function index()
    {
        if ($_SESSION['usuario']) {

            $data = [
                'title' => 'Usuários',
                'view_name' => 'usuariosView',
                'view_data' => ['usuarios' => $this->Usuarios_model->listar_usuarios(),]
            ];
            $this->load->view('templates/layout', $data);
        } else {
            redirect('/');
        }
    }

    function adicionar_usuario()
    {
        $data = [
            'nome' => trim($this->input->post('nome_usuario')),
            'data_nascimento' => $this->input->post('data_nasc_usuario'),
            'sexo' => $this->input->post('sexo_usuario'),
            'matricula' => $this->input->post('matricula'),
        ];

        $resultado = $this->Usuarios_model->inserir_usuario($data);
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);
        redirect('Usuarios');
    }

    function editar_usuarios()
    {
        $id = $this->input->post('usuario_id_editar');
        $data = [
            'nome' => trim($this->input->post('usuario_nome_editar')),
            'matricula' => $this->input->post('usuario_matricula_editar'),
            'data_nascimento' => $this->input->post('usuario_data_nascimento_editar'),
            'sexo' => $this->input->post('usuario_sexo_editar'),
        ];
        $resultado = $this->Usuarios_model->editar_usuarios($id, $data);
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);
        redirect('Usuarios');
    }

    function excluir_usuarios()
    {
        $id = $this->input->post('usuario_id_excluir');
        $resultado = $this->Usuarios_model->excluir_usuarios($id);
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);
        redirect('Usuarios');
    }
}
?>