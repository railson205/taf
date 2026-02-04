<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exercicios_model extends CI_Model
{
    public function __construct()
    {
        $this->nome_tabela = 'exercicios';
    }

    public function listar_exercicios()
    {
        $dados = $this->db
            ->select('
            id,
            nome_do_exercicio,
            modo_de_contagem
            ')
            ->from($this->nome_tabela)
            ->order_by('nome_do_exercicio')
            ->get()
            ->result_array();
        return $dados;
    }

    public function getExercicioById($id)
    {
        return $this->db
            ->from($this->nome_tabela)
            ->where('id', $id)
            ->get()
            ->row_array();
    }

    public function inserir_registro_exercicio($data)
    {
        $exercicio_existe = $this->db->where('nome_do_exercicio', $data['nome_do_exercicio'])->get($this->nome_tabela)->row_array();
        if ($exercicio_existe) {
            return [
                'status' => false,
                'message' => 'Exxercício ja cadastrado.',
                'type' => 'error'
            ];
        }
        $this->db->insert($this->nome_tabela, $data);
        return [
            'status' => $this->db->affected_rows() > 0,
            'message' => 'Exxercício cadastrado.',
            'type' => 'success'
        ];
    }

    public function editar_exercicio($id, $data)
    {
        $this->db->where('id', $id)->update($this->nome_tabela, $data);

        if ($this->db->affected_rows() > 0) {
            return [
                'status' => true,
                'message' => 'Edição bem-sucedida.',
                'type' => 'success'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Nenhuma alteração detectada.',
                'type' => 'warning'
            ];
        }
    }

    public function excluir_exercicios($id)
    {
        $this->db->where('id', $id)->delete($this->nome_tabela);

        if ($this->db->affected_rows() > 0) {
            return [
                'status' => true,
                'message' => 'Resultado excluído com sucesso.',
                'type' => 'success'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Falha ao excluir resultado (ID inexistente).',
                'type' => 'error'
            ];
        }
    }

}
?>