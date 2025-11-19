<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ControladorCondicional extends CI_Controller
{

    public function index()
    {

        if (!$_SESSION['usuario']) {
            redirect('login'); // vai para application/controllers/Login.php
        } else {
            // Redireciona de acordo com o tipo de usuário
            switch ($_SESSION['usuario']['nivel']) {
                case 'admin':
                    redirect('Dashboard');
                    break;
                case 'avaliador':
                    redirect('Resultados');
                    break;
                default:
                    redirect('Resultados');
            }
        }
    }
}
