<?php
defined('BASEPATH') or exit('No direct script access allowed');

function tempo_para_segundos($tempo)
{
    $tempo_slice = explode(':', $tempo);
    return ((int) $tempo_slice[0]) * 60 + (int) $tempo_slice[1];
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


function criar_notas_tabela()
{
    $faixas = [1, 2, 3, 4, 5, 6, 7, 8];
    $inicio = [
        'corrida_2400m' => [tempo_para_segundos('18:40'), 20, 600],
        'flexao_abdominal_supra' => [2, 2, 54],
        'natacao_100m' => [tempo_para_segundos('02:38'), 3, 80],
        'flexao_braco_solo' => [14, 1, 40],
        'natacao_12min' => [25, 25, 675],
    ];
    $fim = [
        'corrida_2400m' => [],
        'flexao_abdominal_supra' => [],
        'natacao_100m' => [],
        'flexao_braco_solo' => [],
        'natacao_12min' => [],
        'flexao_barra_fixa' => [1, 1, 1, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 6, 6, 6, 7, 8, 9, 10, 11, 12, 13, 14]
    ];

    foreach ($inicio as $key => $v) {
        if (in_array($key, ['corrida_2400m', 'natacao_100m'])) {
            for ($i = $v[0]; $i >= $v[2]; $i -= $v[1]) {
                $fim[$key][] = $i;

            }
        } else {
            for ($i = $v[0]; $i <= $v[2]; $i += $v[1]) {
                $fim[$key][] = $i;

            }
        }

    }
    $notas = $fim;
    $nota_inicial = 0.5;
    for ($i = 0; $i < 27; $i++) {
        foreach ($faixas as $key => $f) {
            $nota = $nota_inicial * ($i + 1) - (0.5 * (7 - $key));
            $notas[$f][] = $nota;
        }
    }

    $combined = [];
    $keys = array_keys($notas);        // todas as chaves do array principal
    $length = count($notas[$keys[0]]); // pega o tamanho de qualquer sub-array

    for ($i = 0; $i < $length; $i++) {
        $row = [];
        foreach ($keys as $key) {
            $row[$key] = $notas[$key][$i];
        }
        $combined[] = $row;
    }

    $notas = [];
    foreach ($combined as $c) {
        $dados = ['sexo' => 'Masculino'];
        foreach ($c as $k => $v) {
            if (is_int($k)) {
                if ($v > 0 && $v <= 10) {
                    $dados['faixa_id'] = $k;
                    $dados['nota'] = $v;
                    $notas[] = $dados;
                } else {
                    continue;
                }
            } else {
                $dados[$k] = $v;
            }

        }
    }
    return $notas;
}