<section class="content">
    <div class="container-fluid">
        <?php
        $this->load->view('templates/small_box', [
            'color' => 'bg-warning',
            'value' => count($exercicios),
            'title' => 'Tipos de Exercícios',
            'icon' => 'fa-solid fa-dumbbell'
        ]);
        ?>

        <h3>Adicionar Exercícios</h3>

        <div class="col-md-6">
            <!--Form-->
            <form method="POST" action="<?= site_url("Exercicios/adicionar_exercicios") ?>" class="needs-validation"
                novalidate>

                <!-- Nome do Exercício -->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'nome_exercicio',
                    'title' => 'Nome do Exercício',
                    'placeholder' => 'Ex.: Corrida 2400m',
                    'type' => 'text',
                    'icon_span' => 'abc',
                    'minlength' => 3,
                    'maxlength' => 50,
                ]);
                ?>

                <!-- Modo de Contagem-->
                <?php
                $this->load->view('templates/inputs/input_select', [
                    'id' => 'modo_contagem',
                    'title' => 'Modo de Contagem',
                    'placeholder' => 'Selecione o modo',
                    'options' => ['Contagem', 'Tempo'],
                ]);
                ?>

                <button type="submit" class="btn btn-primary me-1">Novo Exercício</button>
            </form>
            <!--Form-->
        </div>
        <!--Tabela -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h5>Usuários</h5>
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome do Exercício</th>
                                    <th>Modo de Contagem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($exercicios)):
                                    foreach ($exercicios as $key => $e):
                                        ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $e['nome_exercicio'] ?? '-' ?></td>
                                            <td><?= $e['modo_contagem'] ?? '-' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">Nenhum exercício encontrado.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--Tabela -->
        </div>
    </div>

    <!-- Script de Validação Bootstrap -->
    <?php $this->load->view('templates/validator_form'); ?>
</section>