<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notas_exercicios_model extends CI_Model
{

    public function listar_notas_exercicios()
    {
        $dados = $this->db
            ->select('
        CONCAT(f.idade_inicial,"-",f.idade_final) AS faixa_etaria,
        f.nome_grupo as grupo_faixa_etaria,
        ne.sexo,
        ne.valor_nota,
        re.id as exercicio_id,
        re.nome_exercicio,
        re.tipo_exercicio,
        ne.meta_exercicio
    ')
            ->from('notas_exercicios ne')
            ->join('faixas_etarias f', 'f.id = ne.faixa_id')
            ->join('registro_exercicios re', 're.id = ne.registro_exercicio_id')
            ->order_by('ne.valor_nota', 'faixa_etaria', 'ne.sexo')
            ->get()
            ->result_array();

        return $dados;
    }

    public function inserir_nota_exercicio($dados)
    {
        return $this->db->insert('notas_exercicios', $dados);
    }

    function inserir_nova_nota($dados)
    {
        return $this->db->insert('notas_exercicios', $dados);
    }

    function obter_id_valor_nota($nota, $exercicio_id)
    {
        $this->db->where('valor_nota', $nota);
        $this->db->where('registro_exercicio_id', $exercicio_id);
        return $this->db->select('id')->get('notas_exercicios')->row_array()['id'];
    }

    function dados_maior_nota_exercicio($dados_exercicio)
    {
        $usuario_id = $dados_exercicio['usuario_id'];
        $exercicio_id = $dados_exercicio['registro_exercicio_id'];
        $contagem = $dados_exercicio['contagem_exercicio'];

        // Buscar usuário e faixa etária
        $usuario = $this->db->get_where('usuarios', ['id' => $usuario_id])->row_array();
        $faixa_id = $this->Idades_model->get_id_by_faixa($usuario['data_nascimento']);

        // Buscar notas configuradas
        $dados = $this->db
            ->select('
            ne.id as nota_ex_id,
            f.id as faixa_id,
            ne.valor_nota,
            ne.meta_exercicio,
            re.id as registro_exercicio_id,
            re.tipo_exercicio
        ')
            ->from('notas_exercicios ne')
            ->join('faixas_etarias f', 'f.id = ne.faixa_id', 'left')
            ->join('registro_exercicios re', 're.id = ne.registro_exercicio_id', 'left')
            ->where('ne.registro_exercicio_id', $exercicio_id)
            ->where('ne.sexo', $usuario['sexo'])
            ->where('ne.faixa_id', $faixa_id)
            ->order_by('ne.valor_nota', 'ASC')
            ->get()
            ->result_array();

        if (empty($dados))
            return null;

        // Pega o tipo e a meta mínima geral
        $tipo = $dados[0]['tipo_exercicio'];
        $meta_minima = $this->meta_minima($exercicio_id);

        // Define se atingiu o mínimo (tempo menor ou contagem maior)
        $atingiu_meta = $tipo === 'Tempo'
            ? $contagem <= $meta_minima // Tempo deve ser menor ou igual à meta
            : $contagem >= $meta_minima; // Contagem deve ser maior ou igual à meta

        // Caso não tenha atingido o requisito mínimo
        if (!$atingiu_meta) {
            return [
                'nota_ex_id' => null,
                'valor_nota' => 0,
                'meta_exercicio' => $meta_minima,
                'registro_exercicio_id' => $exercicio_id,
                'tipo_exercicio' => $tipo
            ];
        }

        // 🔍 Filtra somente as notas cujas metas foram superadas
        $filtrados = array_filter($dados, function ($linha) use ($tipo, $contagem) {
            if ($tipo === 'Tempo') {
                return $contagem <= $linha['meta_exercicio']; // quanto menor, melhor
            } else {
                return $contagem >= $linha['meta_exercicio']; // quanto maior, melhor
            }
        });

        // Se não sobrou nenhum após o filtro, retorna 0
        if (empty($filtrados)) {
            return [
                'nota_ex_id' => null,
                'valor_nota' => 0,
                'meta_exercicio' => $meta_minima,
                'registro_exercicio_id' => $exercicio_id,
                'tipo_exercicio' => $tipo
            ];
        }

        // 📈 Pega a maior nota entre os que superaram a meta
        $notas = array_column($filtrados, 'valor_nota');
        $max = max($notas);
        $index = array_search($max, $notas);

        // Corrige índice para o original do array filtrado
        $filtrados = array_values($filtrados);
        return $filtrados[$index];
    }




    function exercicio_atingiram_meta($dados_exercicios)
    {
        $exercicio_id = $dados_exercicios['registro_exercicio_id'];
        $faixa_id = $dados_exercicios['faixa_id'];
        $sexo = $dados_exercicios['sexo'];
        $meta = $dados_exercicios['meta_exercicio'];

        $exercicios = $this->db->select('
        ru.id,
        ru.usuario_id,
        ru.faixa_id,
        ru.registro_exercicio_id,
        ru.nota_ex_id,
        u.sexo,
        re.tipo_exercicio,
        eu.contagem_exercicio,
        COALESCE(ne.valor_nota, 0) AS valor_nota,
        ')
            ->from('resultados_usuarios ru')
            ->join('notas_exercicios ne', 'ne.id=ru.nota_ex_id', 'left')
            ->join('registro_exercicios re', 're.id=ru.registro_exercicio_id', 'left')
            ->join('usuarios u', 'u.id=ru.usuario_id', 'left')
            ->join('exercicios_usuarios eu', 'eu.id=ru.exercicio_usuario_id', 'left')
            ->where('ru.faixa_id', $faixa_id)
            ->where('ru.registro_exercicio_id', $exercicio_id)
            ->where('u.sexo', $sexo)
            ->where('(
        CASE 
        WHEN re.tipo_exercicio = "Tempo" THEN ' . $meta . ' >= eu.contagem_exercicio 
        WHEN re.tipo_exercicio = "Contagem" THEN ' . $meta . ' <= eu.contagem_exercicio 
        ELSE FALSE
        END
    )', null, false)
            ->get()
            ->result_array();


        return $exercicios;
    }

    function meta_minima($exercicio_id)
    {
        $this->db->where('registro_exercicio_id', $exercicio_id)->order_by('valor_nota', 'ASC')->limit(1);
        $meta_minima = $this->db->get('notas_exercicios')->row_array()['meta_exercicio'];
        return $meta_minima;
    }
}
?>