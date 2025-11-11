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
    if (count($tempo_slice) == 2 && strlen($tempo_slice[1]) == 1) {
        $tempo_slice[1] = $tempo_slice[1] . '0';
    }
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
    $tempo = sprintf("%02d:%02d min", $min, $seg);
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
                'id' => $row['id'],
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
    ksort($exercicios_unicos);


    return [
        'resultados' => array_values($resultados), // resultados com índice numérico
        'resultados_exericios_unicos' => $exercicios_unicos
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
                'id' => $row['id'],
                'usuario_id' => $uid,
                'nome' => $row['nome'],
                'sexo' => $row['sexo'],
                'data_nascimento' => $row['data_nascimento'],
                'faixa_etaria' => $row['faixa_etaria'],
                'grupo_faixa' => $row['grupo_faixa_etaria'],
                'exercicios' => []
            ];
        }

        // Adiciona o exercício ao usuário
        $resultados[$uid]['exercicios'][] = [
            'exercicio_id' => $row['exercicio_id'],
            'nome_exercicio' => $row['nome_exercicio'],
            'modo_contagem' => $row['modo_contagem'],
            'indice' => $row['indice'],
            'valor_nota' => $row['valor_nota'],
            'nota_id' => $row['nota_id'],
        ];


    }

    ksort($exercicios_unicos);
    return [
        'registro_exercicios' => array_values($resultados), // resultados com índice numérico
        'exercicios_unicos_usuarios' => $exercicios_unicos
    ];
}

function array_is_assoc(array $array)
{
    return array_keys($array) !== range(0, count($array) - 1);
}

/**
 * Recebe um array associativo e vai transformar em um array apropriado para o uso em um input select
 * $key vai ser o nome da key para associar o valor para a key no array associativo
 * @param mixed $array
 * @param mixed $key
 */
function array_para_select($array, $key, $key_value)
{
    $array_options = [];
    foreach ($array as $value) {
        if (is_array($key_value)) {
            $values = [];
            foreach ($key_value as $v) {
                $values[$v] = $value[$v];
            }
        }
        $array_options[] = [$value[$key] => is_array($key_value) ? $values : $value[$key_value]];
    }


    return $array_options;
}

/**
 * Ordena um array multidimensional com base em múltiplas chaves e direções de ordenação.
 *
 * @param array $array O array que será ordenado.
 * @param array $keys Lista das chaves pelas quais o array será ordenado (ex: ['nome', 'idade']).
 * @param array $ordens Lista das direções de ordenação correspondentes (ex: [SORT_ASC, SORT_DESC]).
 * @return array O array ordenado.
 */
function organizar_array(array $array, array $keys, array $ordens): array
{
    // Se não houver chaves, retorna o array original
    if (empty($keys) || empty($array)) {
        return $array;
    }

    $params = [];

    // Monta dinamicamente os parâmetros para o array_multisort
    foreach ($keys as $i => $key) {
        // Extrai a coluna de comparação correspondente à chave
        $coluna = array_column($array, $key);

        // Direção (ordem) da ordenação
        $ordem = $ordens[$i] ?? SORT_ASC;

        // Adiciona os parâmetros necessários ao array de argumentos
        $params[] = $coluna;
        $params[] = $ordem;
    }

    // O último argumento é o array original (por referência)
    $params[] = &$array;

    // Chama array_multisort dinamicamente
    array_multisort(...$params);

    return $array;
}


/**
 * Ordena um array de conjuntos de informações de acordo com o exercício e modo de contagem.
 * 
 * - Agrupa os dados pelo par "Nome do Exercício | Modo de Contagem".
 * - Ordena os grupos pelo número de entradas (maior primeiro).
 * - Dentro de cada grupo, ordena os índices numericamente.
 *   - Se o modo for "Tempo", ordena em ordem decrescente.
 *   - Caso contrário, ordem crescente.
 *
 * @param array $array Array de strings no formato "Exercicio|Indice|Modo----Faixa|Nota"
 * @return array Array ordenado conforme as regras acima.
 */
function ordena_array_indice(array $array): array
{
    $agrupados = [];

    // 1️⃣ Agrupa os elementos por "Exercicio|Modo"
    foreach ($array as $item) {
        [$parteExercicio,] = explode('----', $item);
        [$nome, $indice, $modo] = explode('|', $parteExercicio);
        $chave = "$nome|$modo";
        $agrupados[$chave][] = $item;
    }

    // 2️⃣ Conta quantos itens há em cada grupo
    $quantidades = array_map('count', $agrupados);

    // 3️⃣ Ordena os grupos pela quantidade de elementos (maior primeiro)
    arsort($quantidades);

    // 4️⃣ Recria o array de grupos na nova ordem
    $agrupadosOrdenados = [];
    foreach (array_keys($quantidades) as $chave) {
        $agrupadosOrdenados[$chave] = $agrupados[$chave];
    }

    $resultado = [];

    // 5️⃣ Dentro de cada grupo, ordena os índices de forma adequada
    foreach ($agrupadosOrdenados as $chave => $linhas) {
        $indices = [];

        foreach ($linhas as $linha) {
            [, $indice,] = explode('|', explode('----', $linha)[0]);
            $indices[] = (float)$indice;
        }

        // Se o modo for "Tempo", ordenar DESC; senão ASC
        $ordem = (strpos($chave, 'Tempo') !== false) ? SORT_DESC : SORT_ASC;
        array_multisort($indices, $ordem, $linhas);

        // Adiciona os dados já ordenados ao resultado final
        foreach ($linhas as $linha) {
            $resultado[] = $linha;
        }
    }

    return $resultado;
}




/**
 * Gera uma matriz de índices e notas a partir dos dados agrupados.
 *
 * @param array $agrupado Lista de strings no formato: "Exercicio|Indice|Modo----Faixa|Nota"
 * @param int   $qtdLinhas Número total de linhas da matriz
 * @param array $arrayExercicios Lista de exercícios com ['nome_exercicio']
 * @param array $arrayFaixa Lista de faixas etárias com ['faixa_etaria']
 * @return array Matriz transposta organizada para exibição em tabela
 */
function gera_matriz(array $agrupado, $qtdLinhas, array $arrayExercicios, array $arrayFaixa): array
{
    $matriz = [];

    // 🔹 1. Inicializa a matriz com valor padrão (-1)
    foreach ($arrayExercicios as $ex) {
        $nome = $ex['nome_exercicio'];
        $matriz[$nome] = array_fill(0, $qtdLinhas, -1);
    }

    foreach ($arrayFaixa as $faixa) {
        $nomeFaixa = $faixa['faixa_etaria'];
        $matriz[$nomeFaixa] = array_fill(0, $qtdLinhas, -1);
    }

    // 🔹 2. Índices livres por coluna (para reduzir buscas)
    // Mantém o controle das posições ainda disponíveis em cada linha
    $livres = array_fill(0, $qtdLinhas, true);

    // 🔹 3. Preenche a matriz com os dados de $agrupado
    foreach ($agrupado as $grupo) {

        // Divide o texto em duas partes: exercício/índice e faixa/nota
        [$parteEx, $parteFaixa] = explode('----', $grupo);

        // Extrai dados do exercício
        [$nome, $indice, $modo] = explode('|', $parteEx);
        // Extrai dados da faixa etária e da nota
        [$faixa, $nota] = explode('|', $parteFaixa);

        // Formata o índice caso o modo seja tempo
        $indiceFormatado = ($modo === 'Tempo') ? segundos_para_tempo($indice) : $indice;

        // 🔹 Busca se já existe o índice ou a nota na matriz
        $posIndice = array_search($indiceFormatado, $matriz[$nome], true);
        $posNota = array_search($nota, $matriz[$faixa], true);

        // 🔹 Caso o índice já exista, adiciona a nota na mesma linha
        if ($posIndice !== false) {
            $matriz[$faixa][$posIndice] = $nota;
            $livres[$posIndice] = false;
            continue;
        }

        // 🔹 Caso a nota já exista, adiciona o índice correspondente
        if ($posNota !== false) {
            $matriz[$nome][$posNota] = $indiceFormatado;
            $livres[$posNota] = false;
            continue;
        }

        // 🔹 Caso não exista, busca a primeira linha livre
        $posLivre = array_search(true, $livres, true);
        if ($posLivre === false) {
            // Segurança: caso não haja mais linhas disponíveis
            continue;
        }

        // Preenche o índice e a nota nessa nova linha
        $matriz[$nome][$posLivre] = $indiceFormatado;
        $matriz[$faixa][$posLivre] = $nota;

        // Marca a linha como usada
        $livres[$posLivre] = false;
    }

    // 🔹 4. Transpõe a matriz para que cada linha seja uma combinação completa
    $matrizTransposta = [];
    foreach ($matriz as $coluna => $valores) {
        foreach ($valores as $linha => $valor) {
            $matrizTransposta[$linha][$coluna] = $valor;
        }
    }

    return $matrizTransposta;
}


/**
 * Gera um array de cores em degradê proporcional à quantidade de notas, com alpha fixo.
 *
 * @param float $notaMin Nota mínima
 * @param float $notaMax Nota máxima
 * @param int   $steps Quantidade de tons intermediários
 * @param array $corNotaMin Cor da menor nota no formato [r,g,b]
 * @param array $corNotaMax Cor da maior nota no formato [r,g,b]
 * @param float $alpha Valor da transparência (0.0 a 1.0)
 * @return array Array de strings no formato "rgba(r, g, b, a)"
 */
function geraCoresDegrade($notaMin, $notaMax, $steps, array $corNotaMin, array $corNotaMax, $alpha)
{
    $cores = [];

    // Evita divisão por zero
    $range = max($notaMax - $notaMin, 1);

    // Gera cores intermediárias
    for ($i = 0; $i <= $steps; $i++) {
        $ratio = $i / $steps;

        // Interpolação linear entre as duas cores
        $r = (int) round($corNotaMin[0] + ($corNotaMax[0] - $corNotaMin[0]) * $ratio);
        $g = (int) round($corNotaMin[1] + ($corNotaMax[1] - $corNotaMin[1]) * $ratio);
        $b = (int) round($corNotaMin[2] + ($corNotaMax[2] - $corNotaMin[2]) * $ratio);

        // Calcula a nota correspondente
        $nota = round($notaMin + $ratio * $range, 1);

        // Armazena como RGBA
        $cores[(string) $nota] = "rgba($r, $g, $b, $alpha)";
    }

    return $cores;
}


/**
 * Retorna a cor mais próxima para uma nota específica.
 */
function corParaNota($nota, $mapaCores)
{
    // Caso a nota exata não exista, busca a mais próxima
    $notas = array_keys($mapaCores);
    $maisProxima = $notas[0];
    foreach ($notas as $n) {
        if (abs($n - $nota) < abs($maisProxima - $nota)) {
            $maisProxima = $n;
        }
    }
    return $mapaCores[(string) $maisProxima];
}