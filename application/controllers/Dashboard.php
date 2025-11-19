<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function index()
    {
        if ($_SESSION['usuario']) {
            $data = [
                'title' => 'Dashboard',
                'view_name' => 'dashboardView',
                'view_data' => [
                    'usuarios' => $this->Usuarios_model->listar_usuarios(),
                    'faixas_etarias' => $this->FaixasEtarias_model->listar_faixa_etaria(),
                    'exercicios' => $this->Exercicios_model->listar_exercicios(),
                    'notas' => $this->Notas_model->listar_notas(),
                    'resultados' => $this->Resultados_model->listar_resultados(),
                ]
            ];
            $this->load->view('templates/layout', $data);
        }else{
            redirect('/');
        }

    }
}