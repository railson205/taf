<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notas extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Notas',
            'view_name' => 'notasView',
            'view_data' => ['notas' => $this->Notas_exercicios_model->listar_notas_exercicios(), 'faixa' => $this->Idades_model->listar_faixa_etaria(), 'exercicios' => $this->Tipos_exercicios_model->listar_exercicios()]
        ];
        $this->load->view('templates/layout', $data);
    }

    /*
     Faixa Etária
     Sexo
     Exercício
     Nota
     Indice/Meta
     */
    function adicionar_nota()
    {
        $data = [
            'faixa_id' => $this->input->post('faixa_id_nota'),
            'sexo' => $this->input->post('sexo_nota'),
            'exercicio_id' => $this->input->post('exercicio_id_nota'),
            'valor_nota' => $this->input->post('valor_nota'),
            'indice' => tempo_para_segundos($this->input->post('indice_nota')),
        ];
        debug($data);
        $this->Notas_exercicios_model->inserir_nova_nota($data);
        redirect('Notas');
    }
}