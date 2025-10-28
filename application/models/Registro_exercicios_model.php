<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro_exercicios_model extends CI_Model
{

    public function listar_exercicios()
    {
        $dados = $this->db
            ->select('
            re.id as exercicio_id,
        re.nome_exercicio,
        re.tipo_exercicio
    ')
            ->from('registro_exercicios re')
            ->order_by('re.nome_exercicio')
            ->get()
            ->result_array();
        return $dados;
    }

    public function inserir_registro_exercicio($dados)
    {

        return $this->db->insert('registro_exercicios', $dados);
    }

    function meta_minima($exercicio_id)
    {
        $this->db->where('registro_exercicio_id', $exercicio_id)->order_by('valor_nota', 'ASC')->limit(1);
        $meta_minima = $this->db->get('notas_exercicios')->row_array()['meta_exercicio'];
        return $meta_minima;
    }
}
?>