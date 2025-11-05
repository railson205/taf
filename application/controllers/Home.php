<?php

class Home extends CI_Controller
{

    public function index()
    {
        $data['usuarios'] = $this->Usuarios_model->listar_todos_usuarios();
        $data['faixas_etarias'] = $this->Idades_model->listar_faixa_etaria();
        $data['tipos_exercicios'] = $this->Tipos_exercicios_model->listar_exercicios();
        $data['notas_exercicios'] = $this->Notas_exercicios_model->listar_notas_exercicios();
        //[$data['exercicios_realizados'], $data['exercicios_unicos_usuarios']] = $this->Exercicios_realizados_model->listar_exercicios_realizados();
        //[$data['resultados'], $data['resultados_exercicios_unicos']] = $this->Resultados_usuarios_model->listar_resultados();

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
        $this->Tipos_exercicios_model->inserir_registro_exercicio($data);
        redirect('Home');
    }

    public function inserir_exercicio_usuario()
    {

        $data = [
            'usuario_id' => $this->input->post('usuario_id'),
            'exercicio_id' => $this->input->post('exercicio_id'),
            'contagem_exercicio' => tempo_para_segundos($this->input->post('contagem_exercicio')),
        ];
        $exercicio_usuario_id = $this->Exercicios_realizados_model->inserir_exercicios_realizados($data);
        $this->Resultados_usuarios_model->inserir_resultados_usuarios($data, $exercicio_usuario_id);
        redirect('Home');
    }

    public function inserir_notas_exercicios()
    {
        $data = [
            'faixa_id' => $this->input->post('faixa_etaria_id_nota'),
            'sexo' => $this->input->post('sexo_nota'),
            'valor_nota' => $this->input->post('nota'),
            'exercicio_id' => $this->input->post('exercicio_nota'),
            'meta_exercicio' => tempo_para_segundos($this->input->post('meta_nota')),
        ];
        $this->Notas_exercicios_model->inserir_nota_exercicio($data);
        $this->Resultados_usuarios_model->inserir_notas_resultados($data);
        redirect('Home');
    }


}
?>