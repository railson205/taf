<div class="row mt-4">
    <div class="col-md-12">
        <h5><?= $nome_tabela ?></h5>
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <?php foreach ($header_static as $hs): ?>
                                <th><?= $hs ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($data_array)):
                            foreach ($data_array as $key => $data):
                                ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <?php foreach ($data as $key => $value):
                                        debug([$key, $value]);
                                        if ($key == 'id')
                                            continue;
                                        ?>

                                        <td><?= $value ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>