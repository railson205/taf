<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Demo extends CI_Controller
{

    public function index()
    {
        if ($_SESSION['usuario']) {

            $data = [
                'title' => 'Demo',
                'view_name' => 'adminlte-demo',
                'view_data' => []
            ];
            $this->load->view('templates/layout', $data);
        } else {
            redirect('/');
        }
    }
}
