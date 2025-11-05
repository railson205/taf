<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exercicios_realizados_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notas_exercicios_model');
    }

    public function listar_exercicios_realizados()
    {
        $dados = $this->db
            ->select('
        u.id as usuario_id,
        u.nome,
        u.sexo,
        u.data_nascimento,
        CONCAT(f.idade_inicial,"-",f.idade_final) AS faixa_etaria,
        f.nome_grupo as grupo_faixa_etaria,
        re.id as exercicio_id,
        re.nome_exercicio,
        re.modo_contagem,
        ne.indice
    ')
            ->from('exercicios_realizados eu')
            ->join('usuarios u', 'u.id = eu.usuario_id')
            ->join('tipos_exercicios re', 're.id = eu.exercicio_id')
            ->join('notas_exercicios ne','ne.id=eu.nota_id')
            ->join(
                'faixas_etarias f',
                'TIMESTAMPDIFF(YEAR, u.data_nascimento, DATE(CONCAT(YEAR(CURDATE())-1, "-12-31"))) 
         BETWEEN f.idade_inicial AND f.idade_final'
            )
            ->order_by('u.nome, u.data_nascimento')
            ->get()
            ->result_array();

        return agrupar_exercicios_por_usuarios($dados);
    }

    public function inserir_exercicios_realizados($dados)
    {
        return $this->db->insert('exercicios_realizados',$dados);
    }


}
?>