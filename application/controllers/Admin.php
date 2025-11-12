<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Admin',
            'view_name' => 'AdminView',
            'view_data' => [
            ]
        ];
        $this->load->view('templates/layout', $data);
    }
}