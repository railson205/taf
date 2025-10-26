<?php
defined('BASEPATH') or exit('No direct script access allowed');

function coletar_idade($data_nascimento)
{
    $idade = (date('Y') - formata_data_nascimento($data_nascimento, true)) - 1;
    return $idade;
}

function formata_data_nascimento($data_nascimento, $only_year = false)
{
    $d_nasc = new DateTime($data_nascimento);
    return $only_year ? $d_nasc->format('Y') : $d_nasc->format('d/m/Y');
}


function tempo_para_segundos($tempo)
{
    $tempo_slice = explode(':', $tempo);
    //Trata para o caso de passar um número como string no lugar do tempo
    return count($tempo_slice) == 1 ? (int) $tempo_slice[0] : ((int) $tempo_slice[0]) * 60 + (int) $tempo_slice[1];
}
;

function segundos_para_tempo($segundos)
{
    //Converte segundos para minutos e segundos
    $min = (int) ($segundos / 60);
    $seg = (int) $segundos % 60;
    //Formata 17 e 1 para 17:01
    $tempo = sprintf("%02d:%02d", $min, $seg);
    return $tempo;
}

function debug($data, $ver_array = true)
{
    echo '<pre style="background:#222;color:#0f0;padding:10px;border-radius:6px;font-size:14px;">';

    // se for array ou objeto, percorre; senão, imprime direto
    if ((is_array($data) || is_object($data)) && !$ver_array) {
        foreach ($data as $d) {
            print_r($d);
            echo "\n----------------------------------------\n";
        }
    } else {
        print_r($data);
    }

    echo '</pre>';

}

function organizar_array($array, $key1, $ordem1 = SORT_ASC, $key2 = null, $ordem2 = SORT_ASC)
{
    // Cria a primeira coluna de comparação
    $col1 = array_column($array, $key1);

    if ($key2 !== null) {
        // Se houver uma segunda chave, cria a segunda coluna
        $col2 = array_column($array, $key2);

        // Ordena pelas duas colunas
        array_multisort($col1, $ordem1, $col2, $ordem2, $array);
    } else {
        // Ordena apenas pela primeira
        array_multisort($col1, $ordem1, $array);
    }

    return $array;
}

/**
 * Agrupa os resultados dos exercícios por usuário para tabela dinâmica
 *
 * @param array $usuarios_exercicios Resultado do banco de dados
 * @return array Array estruturado por usuário com sub-array de exercícios
 */
function agrupar_resultados_exercicios_por_usuarios(array $usuarios_exercicios): array
{
    $resultados = [];
    $exercicios_unicos = [];

    foreach ($usuarios_exercicios as $row) {
        $uid = $row['usuario_id'];

        // Exercícios únicos (mantém o nome pelo ID)
        $exercicios_unicos[$row['exercicio_id']] = $row['nome_exercicio'];

        // Se ainda não existe o usuário no array, cria
        if (!isset($resultados[$uid])) {
            $resultados[$uid] = [
                'usuario_id' => $uid,
                'nome' => $row['nome'],
                'sexo' => $row['sexo'],
                'faixa_etaria' => $row['faixa_etaria'],
                'grupo_faixa' => $row['nome_grupo'],
                'nota_final' => 0, // inicia a soma
                'exercicios' => []
            ];
        }

        // Adiciona o exercício ao usuário
        $resultados[$uid]['exercicios'][] = [
            'exercicio_id' => $row['exercicio_id'],
            'nome_exercicio' => $row['nome_exercicio'],
            'tipo_exercicio' => $row['tipo_exercicio'],
            'valor_nota' => $row['valor_nota'],
            'meta_exercicio' => $row['meta_exercicio'],
            'contagem_exercicio' => $row['contagem_exercicio']
        ];

        // Soma o valor da nota ao total do usuário
        $resultados[$uid]['nota_final'] += (float) $row['valor_nota'];
    }

    return [
        array_values($resultados), // resultados com índice numérico
        $exercicios_unicos
    ];
}

/**
 * Agrupa os exercícios por usuário para tabela dinâmica
 *
 * @param array $usuarios_exercicios Resultado do banco de dados
 * @return array Array estruturado por usuário com sub-array de exercícios
 */
function agrupar_exercicios_por_usuarios(array $usuarios_exercicios): array
{
    $resultados = [];
    $exercicios_unicos = [];

    foreach ($usuarios_exercicios as $row) {
        $uid = $row['usuario_id'];

        // Exercícios únicos (mantém o nome pelo ID)
        $exercicios_unicos[$row['exercicio_id']] = $row['nome_exercicio'];

        // Se ainda não existe o usuário no array, cria
        if (!isset($resultados[$uid])) {
            $resultados[$uid] = [
                'usuario_id' => $uid,
                'nome' => $row['nome'],
                'sexo' => $row['sexo'],
                'data_nascimento'=>$row['data_nascimento'],
                'faixa_etaria' => $row['faixa_etaria'],
                'grupo_faixa' => $row['grupo_faixa_etaria'],
                'exercicios' => []
            ];
        }

        // Adiciona o exercício ao usuário
        $resultados[$uid]['exercicios'][] = [
            'exercicio_id' => $row['exercicio_id'],
            'nome_exercicio' => $row['nome_exercicio'],
            'tipo_exercicio' => $row['tipo_exercicio'],
            'contagem_exercicio' => $row['contagem_exercicio']
        ];

        
    }

    return [
        array_values($resultados), // resultados com índice numérico
        $exercicios_unicos
    ];
}



