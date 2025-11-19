<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exercicios extends CI_Controller
{

    public function index()
    {
        if ($_SESSION['usuario']) {

            $data = [
                'title' => 'Exercícios',
                'view_name' => 'exerciciosView',
                'view_data' => ['exercicios' => $this->Exercicios_model->listar_exercicios()]
            ];
            $this->load->view('templates/layout', $data);
        } else {
            redirect('/');
        }
    }

    function adicionar_exercicios()
    {
        $data = [
            'nome_exercicio' => $this->input->post('nome_exercicio'),
            'modo_contagem' => $this->input->post('modo_contagem'),
        ];
        $resultado = $this->Exercicios_model->inserir_registro_exercicio($data);
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Exercicios');
    }

    function editar_exercicios()
    {
        $id = $this->input->post('exercicio_id_editar');
        $data = [
            'nome_exercicio' => $this->input->post('exercicio_nome_editar'),
            'modo_contagem' => $this->input->post('exercicio_modo_contagem_editar'),
        ];
        $resultado = $this->Exercicios_model->editar_exercicios($id, $data);
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Exercicios');

    }

    function excluir_exercicios()
    {
        $id = $this->input->post('exercicio_id_excluir');
        $resultado = $this->Exercicios_model->excluir_exercicios($id);
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Exercicios');
    }
}