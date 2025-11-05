<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead class="table-light">
            <tr>
                <th colspan="<?= count($exercicios) + count($faixa) ?>" class="text-center fs-5">Tabela de Índices e
                    Notas -
                    Masculino
                </th>
            </tr>
            <tr>
                <th colspan="<?= count($exercicios) ?>"
                    class="text-center border-end border-dark bg-secondary text-white">
                    Índices por prova</th>
                <th colspan="<?= count($faixa) ?>" class="text-center bg-secondary text-white">Notas por Faixa Etária
                </th>
            </tr>
            <tr>
                <?php foreach ($exercicios as $e): ?>
                    <th class="text-center border-end border-dark"><?= $e['nome_exercicio'] ?></th>
                <?php endforeach; ?>
                <?php foreach ($faixa as $f): ?>
                    <th class="text-center border-end border-dark"><?= $f['faixa_etaria'] ?></th>
                <?php endforeach; ?>

            </tr>
        </thead>
        <tbody>
            <?php if (!empty($notas)): 
                debug($notas);//Agrupar as notas de acordo com a imagem de notas?>
                
            <?php else: ?>
                <tr>
                    <td colspan="<?= count($exercicios) + count($faixa) ?>">Nenhuma nota encontrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>