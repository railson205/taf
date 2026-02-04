<?php
defined('BASEPATH') or exit('No direct script access allowed');

function coletar_idade($data_de_nascimento)
{
    $idade = (date('Y') - formata_data_de_nascimento($data_de_nascimento, true)) - 1;
    return $idade;
}

function formata_data_de_nascimento($data_de_nascimento, $only_year = false)
{
    $d_nasc = new DateTime($data_de_nascimento);
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

function debug($data, $com_exit = false, $ver_array = true)
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
    if ($com_exit)
        exit();

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
        $exercicios_unicos[$row['exercicio_id']] = $row['nome_do_exercicio'];

        // Se ainda não existe o usuário no array, cria
        if (!isset($resultados[$uid])) {
            $resultados[$uid] = [
                'id' => $row['id'],
                'usuario_id' => $uid,
                'nome' => $row['nome'],
                'sexo' => $row['sexo'],
                'faixa_etaria' => $row['faixa_etaria'],
                'grupo_faixa' => $row['nome_do_grupo'],
                'nota_final' => 0, // inicia a soma
                'exercicios' => []
            ];
        }

        // Adiciona o exercício ao usuário
        $resultados[$uid]['exercicios'][] = [
            'exercicio_id' => $row['exercicio_id'],
            'nome_do_exercicio' => $row['nome_do_exercicio'],
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
        $exercicios_unicos[$row['exercicio_id']] = $row['nome_do_exercicio'];

        // Se ainda não existe o usuário no array, cria
        if (!isset($resultados[$uid])) {
            $resultados[$uid] = [

                'usuario_id' => $uid,
                'nome' => $row['nome'],
                'sexo' => $row['sexo'],
                'data_de_nascimento' => $row['data_de_nascimento'],
                'faixa_etaria' => $row['faixa_etaria'],
                'grupo_faixa' => $row['grupo_faixa_etaria'],
                'faixa_id'=>$row['faixa_id'],
                'exercicios' => []
            ];
        }

        // Adiciona o exercício ao usuário
        $resultados[$uid]['exercicios'][] = [
            'resultado_id' => $row['id'],
            'exercicio_id' => $row['exercicio_id'],
            'nome_do_exercicio' => $row['nome_do_exercicio'],
            'modo_de_contagem' => $row['modo_de_contagem'],
            'indice' => $row['indice'],
            'valor_nota' => $row['valor_nota'],
            'indice_id' => $row['indice_id'],
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
            $indices[] = (float) $indice;
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
 * @param array $arrayExercicios Lista de exercícios com ['nome_do_exercicio']
 * @param array $arrayFaixa Lista de faixas etárias com ['faixa_etaria']
 * @return array Matriz transposta organizada para exibição em tabela
 */
function gera_matriz(array $agrupado, $qtdLinhas, array $arrayExercicios, array $arrayFaixa): array
{
    $matriz = [];

    // 🔹 1. Inicializa a matriz com valor padrão (-1)
    foreach ($arrayExercicios as $ex) {
        $nome = $ex['nome_do_exercicio'];
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

function isMobile()
{
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4));
}

function normalizarString($str)
{
    // Converte para minúsculas (UTF-8 seguro)
    $str = mb_strtolower($str, 'UTF-8');

    // Remove acentos
    $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);

    // Substitui qualquer espaço por _
    $str = preg_replace('/\s+/', '_', $str);

    // Remove tudo que não for letra, número ou _
    $str = preg_replace('/[^a-z0-9_]/', '', $str);

    return $str;
}