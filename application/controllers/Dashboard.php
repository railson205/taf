<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'view_name' => 'dashboardView',
            'view_data' => [
                'usuarios' => $this->Usuarios_model->listar_todos_usuarios(),
                'faixas_etarias' => $this->Idades_model->listar_faixa_etaria(),
                'tipos_exercicios' => $this->Tipos_exercicios_model->listar_exercicios(),
                'notas_exercicios' => $this->Notas_exercicios_model->listar_notas_exercicios(),
                'exercicios_realizados' => $this->Exercicios_realizados_model->listar_exercicios_realizados(),
                'resultados' => $this->Resultados_usuarios_model->listar_resultados(),
            ]
        ];
        $this->load->view('templates/layout', $data);
    }
}

/*HELP: 
-Adicionar novo controller responsável para adicionar o exercício realizado por cada usuário
-Adicionar aos controller opções para edição e remoção dos dados nas tabelas
*/