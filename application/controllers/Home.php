<?php

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $models = ['Usuario_model', 'Idade_model', 'Exercicios_model', 'Resultados_model', 'Notas_model'];
        foreach ($models as $m) {
            $this->load->model($m);
        }
        $this->load->database();
    }
    public function index()
    {
        $data['usuarios'] = $this->Usuario_model->listar_todos_usuarios();
        $data['faixas_etarias'] = $this->Idade_model->listar_faixa_etaria();
        $data['exercicios'] = $this->Exercicios_model->listar_exercicios();
        $data['notas'] = $this->Notas_model->listar_notas();
        $data['resultados'] = $this->Resultados_model->listar_resultados();

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
        $this->Usuario_model->inserir_usuario($nome, $data_nascimento, $sexo);
        redirect('Home');
    }

    public function inserir_faixa_etaria()
    {
        $idade_i = $this->input->post('idade_i');
        $idade_f = $this->input->post('idade_f');
        $this->Idade_model->inserir_faixa_etaria($idade_i, $idade_f);
        redirect('Home');
    }

    public function inserir_resultado()
    {
        $usuario_id = $this->input->post('usuario_id');
        $usuario = $this->Usuario_model->buscar($usuario_id);

        $faixa_etaria = $this->Idade_model->get_faixa_etaria($usuario['data_nascimento']);

        // Monta o registro
        $dados = [
            'usuario_id' => $usuario_id,
            'faixa_id' => $faixa_etaria['id'],
            'corrida_2400m' => tempo_para_segundos($this->input->post('corrida_2400m')),
            'flexao_abdominal_supra' => $this->input->post('flexao_abdominal_supra'),
            'flexao_barra_fixa' => $this->input->post('flexao_barra_fixa'),
            'natacao_100m' => tempo_para_segundos($this->input->post('natacao_100m')),
            'flexao_braco_solo' => $this->input->post('flexao_braco_solo'),
            'natacao_12min' => $this->input->post('natacao_12min'),
        ];

        $this->Exercicios_model->inserir_exercicios($dados);
        redirect('Home');
    }

    public function inserir_notas()
    {

        $dados = [
            'faixa_id' => $this->input->post('faixa_etaria_id'),
            'sexo' => $this->input->post('sexo'),
            'nota' => $this->input->post('nota'),
            'corrida_2400m' => tempo_para_segundos($this->input->post('corrida_2400m')),
            'flexao_abdominal_supra' => $this->input->post('flexao_abdominal_supra'),
            'flexao_barra_fixa' => $this->input->post('flexao_barra_fixa'),
            'natacao_100m' => tempo_para_segundos($this->input->post('natacao_100m')),
            'flexao_braco_solo' => $this->input->post('flexao_braco_solo'),
            'natacao_12min' => $this->input->post('natacao_12min'),
        ];

        $this->Notas_model->inserir_notas($dados);
        redirect("Home");
    }

    public function atualizar_resultados()
    {
        $db_exercicios = $this->Exercicios_model->listar_exercicios();
        $db_notas = organizar_array($this->Notas_model->listar_notas(), 'nota');

        $faixas_notas = array_column($db_notas, 'faixa_id');
        $sexo_notas = array_column($db_notas, 'sexo');

        foreach ($db_exercicios as $value => $e) {
            //Coleta os indexes das notas em que correspondem à mesma faixa etária
            $indexes_faixa_etaria = array_keys($faixas_notas, $e['faixa_id']);
            //Coleta os indexes das notas em que correspondem ao mesmo sexo
            $indexes_sexo = array_keys($sexo_notas, $e['sexo']);
            //Obtem os indexes que correspondem à mesma faixa etária e sexo do usuário
            $intersecao_indexes = array_intersect($indexes_faixa_etaria, $indexes_sexo);

            $exercicio_nao_atingiu_meta = [];
            $nota_por_exercicio = [
                'corrida_2400m' => 0,
                'flexao_abdominal_supra' => 0,
                'flexao_barra_fixa' => 0,
                'natacao_100m' => 0,
                'flexao_braco_solo' => 0,
                'natacao_12min' => 0
            ];
            foreach ($intersecao_indexes as $value => $i) {
                foreach ($nota_por_exercicio as $nome => $nota) {
                    //Para não ocorrer a pesquisa naquele exercício se não for atingido a meta
                    if (in_array($nome, $exercicio_nao_atingiu_meta))
                        continue;
                    //Define quais os exercicios são por tempo
                    $is_tempo = in_array($nome, ['corrida_2400m', 'natacao_100m']);
                    //Coleta o tempo/contagem da meta para conseguir nota
                    $meta_exercicio = $db_notas[$i][$nome];
                    //Valor do exercicio do usuário
                    $valor_usuario = $is_tempo ? tempo_para_segundos($e[$nome]) : $e[$nome];

                    $atingiu_meta = $is_tempo ? $meta_exercicio >= $valor_usuario : $meta_exercicio <= $valor_usuario;

                    //Coleta o tempo/contagem do exercicio do usuário
                    if ($atingiu_meta) {
                        $nota_por_exercicio[$nome] = $db_notas[$i]['nota'];
                    } else {
                        $exercicio_nao_atingiu_meta[] = $nome;
                    }

                }
            }

            $nota_total = 0;
            foreach ($nota_por_exercicio as $nota)
                $nota_total += $nota;

            $informacao_completa = $nota_por_exercicio;
            $informacao_completa['usuario_id'] = $e['usuario_id'];
            $informacao_completa['faixa_id'] = $e['faixa_id'];
            $informacao_completa['nota_total'] = $nota_total;
            $this->Resultados_model->inserir_dados($informacao_completa);
        }
        redirect('Home');

    }

    public function adicionar_notas_tabela()
    {
        $this->Notas_model->adicionar_notas_tabela(criar_notas_tabela());
        redirect("Home");
    }

    public function criar_tabela()
    {
        $this->Notas_model->criar_tabela();
        redirect("Home");
    }
}
?>