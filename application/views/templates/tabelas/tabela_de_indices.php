<table class="table table-striped table-hover table-bordered datatable" style="width: 100%;" data-export-title="Tabela de Índices e Notas - <?= $nome_tabela ?> ">
    <thead class="table-light">
        <tr>
            <th colspan="<?= (isset($infoExercicios) && is_array($infoExercicios) ? count($infoExercicios) : 0) + (isset($infoFaixa) && is_array($infoFaixa) ? count($infoFaixa) : 0) ?>"
                class="text-center fs-5">
                Tabela de Índices e Notas - <?= $nome_tabela ?>
            </th>
        </tr>
        <tr>
            <th colspan="<?= isset($infoExercicios) && is_array($infoExercicios) ? count($infoExercicios) : 0 ?>"
                class="text-center border-end border-dark bg-secondary text-white">
                Índices por Prova
            </th>
            <th colspan="<?= isset($infoFaixa) && is_array($infoFaixa) ? count($infoFaixa) : 0 ?>"
                class="text-center bg-secondary text-white">
                Notas por Faixa Etária
            </th>
        </tr>
        <tr>
            <?php if (!empty($infoExercicios)): ?>
                <?php foreach ($infoExercicios as $e): ?>
                    <th class="text-center border-end border-dark"><?= $e['nome_exercicio'] ?></th>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($infoFaixa)): ?>
                <?php foreach ($infoFaixa as $f): ?>
                    <th class="text-center border-end border-dark"><?= $f['faixa_etaria'] ?></th>
                <?php endforeach; ?>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($infoNotas[(string) $nome_tabela]) && is_array($infoNotas[(string) $nome_tabela])):
            ?>

            <?php
            //Agrupa as informações em um só valor
            $agrupado = [];
            foreach ($infoNotas[(string) $nome_tabela] as $n) {
                $agrupado[] = $n['nome_exercicio'] . '|' . $n['indice'] . '|' . $n['modo_contagem'] . '----' . $n['faixa_etaria'] . '|' . $n['valor_nota'];
            }
            $agrupado = ordena_array_indice($agrupado);
            $linhas = [];
            foreach ($agrupado as $grupo) {
                //Separa o conjunto de faixa etária + nota e nome_exercicio + indice
                $tupla = explode('----', $grupo);
                $verificacao = 0;
                //Caso o conjunto 1 ou 2 tiver algo igual, vai estar na mesma linha só que em colunas diferentes
                foreach ($tupla as $t) {
                    $existe = array_filter($linhas, function ($item) use ($t) {
                        return strpos($item, $t) !== false;
                    });
                    if (!$existe)
                        $verificacao += 1;
                }
                if ($verificacao == 2)
                    $linhas[] = $grupo;

            }
            $faixas = array_column($infoFaixa, 'faixa_etaria');
            $matriz = gera_matriz($agrupado, count($linhas), $infoExercicios, $infoFaixa);
            foreach ($matriz as $coluna):
                ?>
                <tr>
                    <?php foreach ($coluna as $k => $c): ?>
                        <?php if (in_array($k, $faixas)): ?>
                            <?php
                            // Define o estilo da célula
                            if ($c == -1) {
                                $style = 'color: white;';
                            } else {
                                // Converte nota em cor de fundo
                                $cor = htmlspecialchars(corParaNota((float) $c, $cores));
                                $style = "background-color: {$cor}; color: black;";
                            }
                            ?>
                            <td class="text-center" style="<?= $style ?>">
                                <?= $c == -1 ? '' : htmlspecialchars($c) ?>
                            </td>
                        <?php else: ?>
                            <td class="text-center">
                                <?= $c == -1 ? '' : htmlspecialchars($c) ?>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?= (isset($infoExercicios) ? count($infoExercicios) : 0) + (isset($infoFaixa) ? count($infoFaixa) : 0) ?>"
                    class="text-center">
                    Nenhuma nota encontrada.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
