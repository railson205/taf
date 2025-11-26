<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resultados extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($_SESSION['usuario']) {

            $data = [
                'title' => 'Resultados',
                'view_name' => 'resultadosView',
                'view_data' => [
                    'resultados' => $this->Resultados_model->listar_resultados(),
                    'usuarios' => $this->Usuarios_model->listar_usuarios(),
                    'tipos_exercicios' => $this->Exercicios_model->listar_exercicios(),
                    'notas' => $this->Notas_model->listar_notas_para_resultados(),
                    'faixa' => $this->FaixasEtarias_model->listar_faixa_etaria(),
                ]
            ];
            $this->load->view('templates/layout', $data);
        } else {
            redirect('/');
        }
    }

    function adicionar_resultados()
    {
        $data = [
            'usuario_id' => $this->input->post('usuario_id'),
            'exercicio_id' => $this->input->post('exercicio_id'),
            'nota_id' => $this->input->post('nota_id'),
            'avaliador_id' => $this->input->post('avaliador_id'),
        ];
        $resultado = $this->Resultados_model->inserir_resultados($data);
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Resultados');
    }

    function editar_resultados()
    {
        $id = $this->input->post('resultados_id_editar');
        $data = [
            'nota_id' => $this->input->post('resultados_indice_editar'),
        ];

        $resultado = $this->Resultados_model->editar_resultados($id, $data);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Resultados');
    }

    function excluir_resultados()
    {
        $id = $this->input->post('resultados_id_excluir');
        $resultado = $this->Resultados_model->excluir_resultados($id);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Resultados');
    }
}