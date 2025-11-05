<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exercicios extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Exercícios',
            'view_name' => 'exerciciosView',
            'view_data' => ['exercicios'=>$this->Tipos_exercicios_model->listar_exercicios()]
        ];
        $this->load->view('templates/layout',$data);
    }

    function adicionar_exercicios(){
        $data = [
            'nome_exercicio' => $this->input->post('nome_exercicio'),
            'modo_contagem' => $this->input->post('modo_contagem'),
        ];
        $this->Tipos_exercicios_model->inserir_registro_exercicio($data);
        redirect('Exercicios');
    }
}