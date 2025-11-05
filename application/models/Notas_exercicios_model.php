<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notas_exercicios_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tipos_exercicios_model');
    }

    public function listar_notas_exercicios()
    {
        $dados = $this->db
            ->select('
            ne.id,
        CONCAT(f.idade_inicial,"-",f.idade_final) AS faixa_etaria,
        f.nome_grupo as grupo_faixa_etaria,
        ne.sexo,
        ne.valor_nota,
        re.id as exercicio_id,
        re.nome_exercicio,
        re.modo_contagem,
        ne.indice,
        f.id as faixa_id,
    ')
            ->from('notas_exercicios ne')
            ->join('faixas_etarias f', 'f.id = ne.faixa_id')
            ->join('tipos_exercicios re', 're.id = ne.exercicio_id')
            ->order_by('ne.valor_nota', 'faixa_etaria', 'ne.sexo')
            ->get()
            ->result_array();

        return $dados;
    }

    function listar_notas_para_exercicios_realizados()
    {
        $dados = $this->db
            ->select('
            ne.id,
            ne.indice,
            ne.sexo,
            ne.exercicio_id,
            f.id as faixa_id,
            re.modo_contagem,
    ')
            ->from('notas_exercicios ne')
            ->join('faixas_etarias f', 'f.id = ne.faixa_id')
            ->join('tipos_exercicios re', 're.id = ne.exercicio_id')
            ->order_by('ne.valor_nota', 'faixa_etaria', 'ne.sexo')
            ->get()
            ->result_array();

        return $dados;
    }

    function inserir_nova_nota($dados)
    {
        return $this->db->insert('notas_exercicios', $dados);
    }

}
?>