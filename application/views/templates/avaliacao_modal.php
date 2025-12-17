<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="<?= $id ?>_label">Avaliação </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">

                <?php if (!empty($exercicios)): ?>
                    <div class="p-3">

                        <h6 class="fw-bold mb-3">Detalhes do Exercício</h6>

                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Quantidade de Exercícios</th>
                                    <th>Nota Média</th>
                                    <th>Nota Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $nota_total = 0;
                                $qtd_notas = 0;
                                foreach ($exercicios as $exec) {
                                    $nota_total += (int) $exec['valor_nota'];
                                    $qtd_notas += 1;
                                } ?>
                                <tr>
                                    <td><?= $qtd_notas ?></td>
                                    <td><?= $nota_total / $qtd_notas ?></td>
                                    <td><?= $nota_total ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <h6 class="fw-bold mb-3">Lista dos Exercício</h6>
                        <table class="table table-striped table-hover table-bordered datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Modo Contagem</th>
                                    <th>Índice</th>
                                    <th>Nota</th>
                                    <?php if (in_array($_SESSION['usuario']['nivel'], ['Avaliador', 'Administrador']) && !isset($isDashboard)): ?>
                                        <th>Ações</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($exercicios as $exec): ?>
                                    <tr>
                                        <td><?= $exec['nome_exercicio'] ?></td>
                                        <td><?= $exec['modo_contagem'] ?></td>
                                        <td><?= $exec['modo_contagem'] == "Tempo" ? segundos_para_tempo($exec['indice']) : $exec['indice'] ?>
                                        </td>
                                        <td><?= $exec['valor_nota'] ?></td>
                                        <?php if (in_array($_SESSION['usuario']['nivel'], ['Avaliador', 'Administrador']) && !isset($isDashboard)): ?>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#resultados_modal_editar" data-selecionado='<?= json_encode([
                                                        "id" => $exec["resultado_id"],
                                                        "usuario_id" => $registro['usuario_id'],
                                                        "exercicio_id" => $exec["exercicio_id"],
                                                        "indice_id" => $exec['indice_id'],
                                                        'nome' => $registro['nome'],
                                                        'sexo' => $registro['sexo'],
                                                        'faixa' => $registro['faixa_etaria'],
                                                        'grupo_faixa' => $registro['grupo_faixa'],
                                                        'indice' => $exec['indice'],
                                                    ]) ?>' data-opcoes='<?= json_encode([
                                                         'usuarios' => $usuarios_options,
                                                         "exercicios" => $exercicios_options,
                                                         'notas' => $indices_id_options,
                                                         'all_exercicios' => $tipos_exercicios,
                                                     ]) ?>'>
                                                    <i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#resultados_modal_excluir" data-selecionado='<?= json_encode([
                                                        "id" => $exec["resultado_id"],
                                                        "usuario_id" => $registro['usuario_id'],
                                                        "exercicio_id" => $exec["exercicio_id"],
                                                        "indice_id" => $exec['indice_id'],
                                                        'nome' => $registro['nome'],
                                                        'sexo' => $registro['sexo'],
                                                        'faixa' => $registro['faixa_etaria'],
                                                        'grupo_faixa' => $registro['grupo_faixa'],
                                                        'indice' => $exec['indice'],
                                                    ]) ?>' data-opcoes='<?= json_encode([
                                                         'usuarios' => $usuarios_options,
                                                         "exercicios" => $exercicios_options,
                                                         'notas' => $indices_id_options,
                                                         'all_exercicios' => $tipos_exercicios,
                                                     ]) ?>'><i class="fas fa-trash"></i></button>

                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                <?php else: ?>
                    <div class="p-3 text-muted">Nenhum detalhe encontrado.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>