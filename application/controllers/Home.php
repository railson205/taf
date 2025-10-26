<?php

class Home extends CI_Controller
{
    //HELP:ajustar os models para verificar somente em suas tabelas
    public function __construct()
    {
        parent::__construct();
        $models = ['Usuarios_model', 'Idades_model', 'Registro_exercicios_model', 'Exercicios_usuarios_model', 'Notas_exercicios_model', 'Resultados_usuarios_model'];
        foreach ($models as $m) {
            $this->load->model($m);
        }
        $this->load->database();
    }
    public function index()
    {
        $data['usuarios'] = $this->Usuarios_model->listar_todos_usuarios();
        $data['faixas_etarias'] = $this->Idades_model->listar_faixa_etaria();
        $data['registro_exercicios'] = $this->Registro_exercicios_model->listar_exercicios();
        [$data['exercicios_usuarios'],$data['exercicios_unicos_usuarios']] = $this->Exercicios_usuarios_model->listar_exercicios_usuarios();
        $data['notas_exercicios'] = $this->Notas_exercicios_model->listar_notas_exercicios();
        [$data['resultados'], $data['resultados_exercicios_unicos']] = $this->Resultados_usuarios_model->listar_resultados();

        $this->load->view('home_view', $data);
    }

    public function inserir_usuario()
    {
        $nome = trim($this->input->post('nome'));
        $data_nascimento = $this->input->post('data_nascimento');
        $sexo = $this->input->post('sexo');

        #Verifica se na variável nome contém pelo menos um espaço no meio
        if (strpos($nome, ' ') === false) {
            $this->session->set_flashdata('erro', 'Digite pelo menos nome e sobrenome.');
            redirect('Home');
        }
        $this->Usuarios_model->inserir_usuario($nome, $data_nascimento, $sexo);
        redirect('Home');
    }

    public function inserir_faixa_etaria()
    {
        $data = [
            'nome_grupo' => $this->input->post('nome_grupo'),
            'idade_inicial' => $this->input->post('idade_i'),
            'idade_final' => $this->input->post('idade_f')
        ];
        $this->Idades_model->inserir_faixa_etaria($data);
        redirect('Home');
    }

    public function inserir_registro_exercicio()
    {
        $data = [
            'nome_exercicio' => $this->input->post('nome_exercicio'),
            'tipo_exercicio' => $this->input->post('tipo_exercicio'),
        ];
        $this->Registro_exercicios_model->inserir_registro_exercicio($data);
        redirect('Home');
    }

    public function inserir_exercicio_usuario()
    {

        $data = [
            'usuario_id' => $this->input->post('usuario_id'),
            'registro_exercicio_id' => $this->input->post('exercicio_id'),
            'contagem_exercicio' => tempo_para_segundos($this->input->post('contagem_exercicio')),
        ];
        $exercicio_usuario_id = $this->Exercicios_usuarios_model->inserir_exercicios_usuarios($data);
        $this->Resultados_usuarios_model->inserir_resultados_usuarios($data, $exercicio_usuario_id);
        redirect('Home');
    }

    public function inserir_notas_exercicios()
    {
        $data = [
            'faixa_id' => $this->input->post('faixa_etaria_id_nota'),
            'sexo' => $this->input->post('sexo_nota'),
            'valor_nota' => $this->input->post('nota'),
            'registro_exercicio_id' => $this->input->post('exercicio_nota'),
            'meta_exercicio' => tempo_para_segundos($this->input->post('meta_nota')),
        ];
        $this->Notas_exercicios_model->inserir_nota_exercicio($data);
        $this->Resultados_usuarios_model->inserir_notas_resultados($data);
        redirect('Home');
    }


}
?>