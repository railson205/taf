<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resultados_usuarios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notas_exercicios_model');
    }

    function listar_resultados()
    {
        $dados = $this->db
            ->select('
        u.id AS usuario_id,
        u.nome,
        u.sexo,
        CONCAT(f.idade_inicial, "-", f.idade_final) AS faixa_etaria,
        f.nome_grupo,
        re.id AS exercicio_id,
        re.nome_exercicio,
        re.modo_contagem,
        COALESCE(ne.valor_nota, 0) AS valor_nota,
    ')
            ->from('resultados_usuarios r')
            ->join('usuarios u', 'u.id = r.usuario_id')
            ->join('faixas_etarias f', 'f.id = r.faixa_id')
            ->join('tipos_exercicios re', 're.id = r.exercicio_id')
            ->join('exercicios_realizados eu', 'eu.id = r.exercicio_realizado_id')
            // join padrão
            ->join('notas_exercicios ne', 'ne.id = r.nota_id', 'left')
            // subquery que pega a menor nota possível da combinação correspondente
            ->join('(
        SELECT exercicio_id, faixa_id, sexo, MIN(valor_nota) AS valor_nota
        FROM notas_exercicios
        GROUP BY exercicio_id, faixa_id, sexo
    ) AS nmin',
                'nmin.exercicio_id = re.id 
         AND nmin.faixa_id = f.id 
         AND nmin.sexo = u.sexo',
                'left'
            )
            ->order_by('u.id, re.id')
            ->get()
            ->result_array();


        return agrupar_resultados_exercicios_por_usuarios($dados);
    }


}
?>