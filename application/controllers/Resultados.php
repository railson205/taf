<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resultados extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Resultados',
            'view_name' => 'resultadosView',
            'view_data' => []
        ];
        $this->load->view('templates/layout',$data);
    }
}