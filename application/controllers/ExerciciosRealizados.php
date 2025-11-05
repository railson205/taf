<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exerciciosrealizados extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Exercícios Realizados',
            'view_name' => 'exerciciosRealizadosView',
            'view_data' => [
                'exercicios_realizados' => $this->Exercicios_realizados_model->listar_exercicios_realizados(),
                'usuarios' => $this->Usuarios_model->listar_todos_usuarios(),
                'tipos_exercicios' => $this->Tipos_exercicios_model->listar_exercicios(),
                'notas' => $this->Notas_exercicios_model->listar_notas_para_exercicios_realizados(),
                'faixa' => $this->Idades_model->listar_faixa_etaria(),
            ]
        ];
        $this->load->view('templates/layout', $data);
    }

    function adicionar_exercicio_realizado()
    {
        $data = [
            'usuario_id' => $this->input->post('usuario_id'),
            'exercicio_id' => $this->input->post('exercicio_id'),
            'nota_id' => $this->input->post('nota_id'),
        ];
       $this->Exercicios_realizados_model->inserir_exercicios_realizados($data);
        redirect('ExerciciosRealizados');
    }
}