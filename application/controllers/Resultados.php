<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resultados extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($_SESSION['usuario']) {

            $data = [
                'title' => 'Resultados',
                'view_name' => 'resultadosView',
                'view_data' => [
                    'resultados' => $this->Resultados_model->listar_resultados(),
                    'usuarios' => $this->Usuarios_model->listar_usuarios(),
                    'tipos_exercicios' => $this->Exercicios_model->listar_exercicios(),
                    'notas' => $this->Notas_model->listar_notas_para_resultados(),
                    'faixa' => $this->FaixasEtarias_model->listar_faixa_etaria(),
                ]
            ];
            $this->load->view('templates/layout', $data);
        } else {
            redirect('/');
        }
    }

    function adicionar_resultados()
    {
        $seguranca = $this->Seguranca_model;
        $uid = $this->input->post('usuario_id');
        $data = [
            'exercicio_id' => $this->input->post('exercicio_id'),
            'indice_id' => $this->input->post('indice_id'),
            'avaliador_id' => '1',//$this->input->post('avaliador_id'),
            'atleta_id' => $seguranca->getIdByUsuarioId($uid)
        ];


        /**<p>Olá, <strong>{$usuario['nome']}</strong></p>
        <p>Para redefinir sua senha, clique no link abaixo:</p>
        <p><a href='{$link}'>Redefinir minha senha</a></p>" */


        /*
        Atleta:
        Olá, atleta, o avaliador NOME adicionou o resultado de um exercício que você fez,
        abaixo mostra as informações detalhadas do exercício realizado.

        Olá, atleta, o avaliador NOME modificou o resultado de um exercício que você fez,
        abaixo mostra o log de alterações do exercício realizado.


        Avaliador:
        Olá, avaliador, você adicionou o resultado de um exercício realizado pelo atleta
        NOME, abaixo mostra as informações detalhadas do exercício adicionado.

        Olá, avaliador, você modificou um resultado de exercício realizado pelo atleta
        NOME, abaixo mostra o log de alterações do exercício modificado.
        */

        /*
        Exercícios:
        Nome do exercício
        Tipo de Contagem
        Índice realizado
        Nota Recebida
        */

        $avaliador = [
            'email' => $seguranca->getEmailById($data['avaliador_id']),
            'htmlEmail' => '
        
        '
        ];
        $dadosEmail = $this->montarEmailResultado('add', 'atleta', [
            'nome' => $this->Seguranca_model->getNomeById($data['atleta_id']),
            'exercicio' => $this->Exercicios_model->getExercicioById($data['exercicio_id']),
            'resultado' => $this->Notas_model->getNotasById($data['indice_id'])
        ]);
        $atleta = [
            'email' => $seguranca->getEmailById($data['atleta_id']),
            'htmlEmail' => "
        <p>Olá, <strong>{)}</strong></p>
        <p>O avaliador {$this->Seguranca_model->getNomeById($data['avaliador_id'])} adicionou o resultado de um exercício que você fez,</p>
        <p>abaixo mostra as informações detalhadas do exercício realizado.</p>
        "
        ];
        $this->load->library('email_service');

        debug($data);
        debug($dadosEmail);
        //$resultado = $this->Resultados_model->inserir_resultados($data, $uid);
        //$this->Log_model->inserirLog($data);

        /*$this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Resultados');*/
    }

    function editar_resultados()
    {
        $id = $this->input->post('resultados_id_editar');
        $data = [
            'indice_id' => $this->input->post('resultados_indice_editar'),
        ];

        $resultado = $this->Resultados_model->editar_resultados($id, $data);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Resultados');
    }

    function excluir_resultados()
    {
        $id = $this->input->post('resultados_id_excluir');
        $resultado = $this->Resultados_model->excluir_resultados($id);

        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Resultados');
    }

    private function montarEmailResultado($acao, $perfil, $dados)
    {
        $isAdicao = $acao === 'add';
        $isAtleta = $perfil === 'atleta';

        return [
            'titulo' => ($isAdicao ? 'Novo resultado ' : 'Resultado atualizado ') .
                ($isAtleta ? 'do atleta' : 'avaliado'),

            'cor_titulo' => $isAdicao ? '#28a745' : '#ffc107',

            'nome_destinatario' => $dados['nome'],

            'mensagem_principal' => $isAtleta
                ? ($isAdicao
                    ? 'Um novo resultado foi registrado para você.'
                    : 'Um resultado seu foi atualizado.')
                : ($isAdicao
                    ? 'Você registrou um novo resultado.'
                    : 'Você atualizou um resultado.'),

            'mensagem_final' => $isAtleta
                ? 'Caso tenha dúvidas, procure o avaliador responsável.'
                : 'Obrigado por manter os registros atualizados.',

            'exercicio' => $dados['exercicio'],
            'resultado' => $dados['resultado'],
            'observacao' => $dados['observacao'] ?? null,
        ];
    }
}