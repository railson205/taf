<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FaixasEtarias_model extends CI_Model
{
    public function __construct()
    {
        $this->nome_tabela = 'faixas_etarias';
    }

    public function listar_faixa_etaria()
    {
        $dados = $this->db->select('
        id,
        nome_grupo,
        idade_inicial,
        idade_final,
        CONCAT(idade_inicial,"-",idade_final) AS faixa_etaria,
        ')
            ->from($this->nome_tabela)
            ->order_by('idade_inicial')
            ->get()
            ->result_array();
        return $dados;
    }

    public function inserir_faixa_etaria($data)
    {
        $faixa_existe = $this->db->where('idade_inicial', $data['idade_inicial'])->where('idade_final', $data['idade_final'])->get($this->nome_tabela)->row_array();
        if ($faixa_existe) {
            return [
                'status'=>false,
                'message'=>'Faixa Etária ja cadastrada.',
                'type'=>'danger'
            ];
        }
        $this->db->insert($this->nome_tabela, $data);
        return [
                'status'=>$this->db->affected_rows()>0,
                'message'=>'Faiax Etária cadastrada.',
                'type'=>'success'
            ];
    }
    public function editar_faixa($id, $data)
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

    public function excluir_faixa($id)
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
                'type' => 'danger'
            ];
        }
    }

}
?>