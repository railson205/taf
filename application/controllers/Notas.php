<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notas extends CI_Controller
{

    public function index()
    {
        if ($_SESSION['usuario']) {

            $data = [
                'title' => 'Notas',
                'view_name' => 'notasView',
                'view_data' => ['notas' => $this->Notas_model->listar_Notas(), 'faixa' => $this->FaixasEtarias_model->listar_faixa_etaria(), 'exercicios' => $this->Exercicios_model->listar_exercicios()]
            ];
            $this->load->view('templates/layout', $data);
        } else {
            redirect('/');
        }
    }

    function adicionar_nota()
    {
        $data = [
            'faixa_id' => $this->input->post('faixa_id_nota'),
            'sexo' => $this->input->post('sexo_nota'),
            'exercicio_id' => $this->input->post('exercicio_id_nota'),
            'valor_nota' => $this->input->post('valor_nota'),
            'indice' => tempo_para_segundos($this->input->post('indice_nota')),
        ];
        $resultado = $this->Notas_model->inserir_nova_nota($data);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Notas');
    }

    function editar_nota()
    {
        $id = $this->input->post('notas_id_editar');
        $data = [
            'faixa_id' => $this->input->post('notas_faixa_editar'),
            'sexo' => $this->input->post('notas_sexo_editar'),
            'valor_nota' => $this->input->post('notas_valor_nota_editar'),
            'exercicio_id' => $this->input->post('notas_exercicio_editar'),
            'indice' => tempo_para_segundos($this->input->post('notas_indice_editar')),
        ];
        $resultado = $this->Notas_model->editar_notas($id, $data);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Notas');
    }

    function excluir_nota()
    {
        $id = $this->input->post('notas_id_excluir');

        $resultado = $this->Notas_model->excluir_notas($id);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Notas');
    }
}