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
            'avaliador_id' => $this->input->post('avaliador_id'),
            'atleta_id' => $seguranca->getIdByUsuarioId($uid)
        ];

        //Avaliador
        $dadosEmail = $this->montarEmailResultado('add', 'avaliador', [
            'nome' => $this->Seguranca_model->getNomeById($data['avaliador_id']),
            'exercicio' => $this->Exercicios_model->getExercicioById($data['exercicio_id']),
            'resultados' => $this->formataResultadosEmail([$data])
        ]);

        $avaliador = [
            'email' => $seguranca->getEmailById($data['avaliador_id']),
            'htmlEmail' => $this->load->view('templates/corpo_email', $dadosEmail, true)
        ];
        //Avaliador

        //Atleta
        $dadosEmail = $this->montarEmailResultado('add', 'atleta', [
            'nome' => $this->Seguranca_model->getNomeById($data['atleta_id']),
            'exercicio' => $this->Exercicios_model->getExercicioById($data['exercicio_id']),
            'resultados' => $this->formataResultadosEmail([$data])
        ]);
        $atleta = [
            'email' => $seguranca->getEmailById($data['atleta_id']),
            'htmlEmail' => $this->load->view('templates/corpo_email', $dadosEmail, true)
        ];
        //Atleta


        $resultado = $this->Resultados_model->inserir_resultados($data, $uid);
        $this->Log_model->inserirLog($data, $resultado['id']);

        //Envia email para avaliador e atleta
        $this->load->library('email_service');
        $this->email_service->enviar($atleta['email'], 'Novo resultado', $atleta['htmlEmail']);
        $this->email_service->enviar($avaliador['email'], 'Novo resultado', $avaliador['htmlEmail']);

        //Define o conteúdo do alerta
        $this->session->set_flashdata('alert_type', $resultado['type']);
        $this->session->set_flashdata('alert_message', $resultado['message']);

        redirect('Resultados');
    }

    function editar_resultados()
    {
        $id = $this->input->post('resultados_id_editar');
        $data = [
            'indice_id' => $this->input->post('resultados_indice_editar'),
        ];

        $info_log = $this->Log_model->getInfoByResultadoId($id);

        //Avaliador
        $dadosEmail = $this->montarEmailResultado('att', 'avaliador', [
            'nome' => $this->Seguranca_model->getNomeById($info_log[0]['avaliador_id']),
            'exercicio' => $this->Exercicios_model->getExercicioById($info_log[0]['exercicio_id']),
            'resultados' => $this->formataResultadosEmail($info_log)
        ]);

        $avaliador = [
            'email' => $this->Seguranca_model->getEmailById($info_log[0]['avaliador_id']),
            'htmlEmail' => $this->load->view('templates/corpo_email', $dadosEmail, true)
        ];
        //Avaliador

        //Atleta
        $dadosEmail = $this->montarEmailResultado('att', 'atleta', [
            'nome' => $this->Seguranca_model->getNomeById($info_log[0]['atleta_id']),
            'exercicio' => $this->Exercicios_model->getExercicioById($info_log[0]['exercicio_id']),
            'resultados' => $this->formataResultadosEmail($info_log)
        ]);
        $atleta = [
            'email' => $this->Seguranca_model->getEmailById($info_log[0]['atleta_id']),
            'htmlEmail' => $this->load->view('templates/corpo_email', $dadosEmail, true)
        ];

        //Atleta
        $resultado = $this->Resultados_model->editar_resultados($id, $data);
        $this->Log_model->atualizarLog($id, $data['indice_id']);

        //Envia email para avaliador e atleta
        $this->load->library('email_service');
        $this->email_service->enviar($atleta['email'], 'Novo resultado', $atleta['htmlEmail']);
        $this->email_service->enviar($avaliador['email'], 'Novo resultado', $avaliador['htmlEmail']);

        //Define o conteúdo do alerta
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
                    ? 'Um novo resultado foi registrado para você. Abaixo está a informação detalhada sobre o exercício.'
                    : 'Um resultado seu foi atualizado. Abaixo está o log de alterações do exercício.')
                : ($isAdicao
                    ? 'Você registrou um novo resultado. Abaixo está a informação detalhada sobre o exercício registrado.'
                    : 'Você atualizou um resultado. Abaixo está o log de alterações do exercício.'),

            'mensagem_final' => $isAtleta
                ? 'Caso tenha dúvidas, procure o avaliador responsável.'
                : 'Obrigado por manter os registros atualizados.',

            'exercicio' => $dados['exercicio'],
            'resultados' => $dados['resultados'],
            'observacao' => $dados['observacao'] ?? null,
        ];
    }

    private function formataResultadosEmail($resultados)
    {
        $resultadoFormatado = [];
        foreach ($resultados as $r) {
            $resultadoFormatado[] = [
                'valor_nota' => $this->Notas_model->getNotasById($r['indice_id'])['valor_nota'],
                'indice' => $this->Notas_model->getNotasById($r['indice_id'])['indice'],
                'obersavação' => '',
                'avaliado_em' => $r['criado_em'] ?? '',
                'atualizado_em' => $r['atualizado_em'] ?? ''
            ];
        }
        return $resultadoFormatado;
    }
}