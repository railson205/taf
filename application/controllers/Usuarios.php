<?php

class Usuarios extends CI_Controller
{
    public function index()
    {
        $data = [
            'title' => 'Usuários',
            'view_name' => 'usuariosView',
            'view_data' => ['usuarios' => $this->Usuarios_model->listar_todos_usuarios(),]
        ];
        $this->load->view('templates/layout', $data);
    }

    function adicionar_usuario()
    {
        $data = [
            'nome' => trim($this->input->post('nome_usuario')),
            'data_nascimento' => $this->input->post('data_nasc_usuario'),
            'sexo' => $this->input->post('sexo_usuario'),
        ];
        
        $this->Usuarios_model->inserir_usuario($data);
        redirect('Usuarios');
    }
}
?>