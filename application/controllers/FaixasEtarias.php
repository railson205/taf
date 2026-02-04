<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FaixasEtarias extends CI_Controller
{

    public function index()
    {
        if ($_SESSION['usuario']) {

            $data = [
                'title' => 'Faixas Etárias',
                'view_name' => 'faixasEtariasView',
                'view_data' => ['faixas_etarias' => $this->FaixasEtarias_model->listar_faixa_etaria()]
            ];
            $this->load->view('templates/layout', $data);
        } else {
            redirect('/');
        }
    }

    function adicionar_faixa_etaria()
    {
        $data = [
            'nome_do_grupo' => $this->input->post('nome_do_grupo'),
            'idade_inicial' => $this->input->post('idade_i'),
            'idade_final' => $this->input->post('idade_f')
        ];
        $resultado = $this->FaixasEtarias_model->inserir_faixa_etaria($data);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('FaixasEtarias');
    }

    function editar_faixa()
    {
        $id = $this->input->post('faixa_etaria_id_editar');
        $data = [
            'nome_do_grupo' => $this->input->post('faixa_etaria_nome_do_grupo_editar'),
            'idade_inicial' => $this->input->post('faixa_etaria_idade_inicial_editar'),
            'idade_final' => $this->input->post('faixa_etaria_idade_final_editar')
        ];
        debug([$id,$data]);
        $resultado = $this->FaixasEtarias_model->editar_faixa($id, $data);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('FaixasEtarias');
    }

    function excluir_faixa()
    {
        $id = $this->input->post('faixa_id_excluir');

        $resultado = $this->FaixasEtarias_model->excluir_faixa($id);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('FaixasEtarias');
    }
}