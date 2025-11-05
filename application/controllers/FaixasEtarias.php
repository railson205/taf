<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FaixasEtarias extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Faixas Etárias',
            'view_name' => 'faixasEtariasView',
            'view_data' => ['faixas_etarias'=>$this->Idades_model->listar_faixa_etaria()]
        ];
        $this->load->view('templates/layout',$data);
    }

    function adicionar_faixa_etaria(){
        $data = [
            'nome_grupo' => $this->input->post('nome_grupo'),
            'idade_inicial' => $this->input->post('idade_i'),
            'idade_final' => $this->input->post('idade_f')
        ];
        $this->Idades_model->inserir_faixa_etaria($data);
        redirect('FaixasEtarias');
    }
}