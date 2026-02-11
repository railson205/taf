<section class="content">
    <div class="container-fluid">
        <?php
        $this->load->view('templates/small_box', [
            'color' => 'argila',
            'value' => count($exercicios),
            'title' => 'Tipos de Exercícios',
            'icon' => 'fa-solid fa-dumbbell'
        ]);
        ?>

        <?php
        modalEditar($this, 'Exercício', 'Exercicios/editar_exercicio', ['Nome do exercício|text', 'Modo de contagem|select']);
        modalExcluir($this, 'Exercício', 'Exercicios/excluir_exercicio', ['Nome do exercício', 'Modo de contagem']);
        ?>

        <?php
        $alert_type = $this->session->flashdata('alert_type');
        $alert_message = $this->session->flashdata('alert_message');

        if ($alert_message): ?>
            <script>
                Swal.fire({
                    title: "Aviso",
                    text: "<?= $alert_message ?>",
                    icon: "<?= $alert_type ?>", // success, error, warning, info
                    confirmButtonText: "OK"
                });
            </script>
        <?php endif; ?>

        <div class="col-md-6">
            <h3>Adicionar Exercícios</h3>
            <!--Form-->
            <form method="POST" action="<?= site_url("Exercicios/adicionar_exercicios") ?>" class="needs-validation"
                novalidate>

                <!-- Nome do Exercício -->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'nome_do_exercicio',
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
                    'id' => 'modo_de_contagem',
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
                <h5>Exercícios</h5>

                <table class="table table-striped table-hover table-bordered datatable" style="width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Nome do Exercício</th>
                            <th>Modo de Contagem</th>
                            <th style="width: 120px;">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($exercicios)): ?>
                            <?php foreach ($exercicios as $key => $e): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $e['nome_do_exercicio'] ?? '-' ?></td>
                                    <td><?= $e['modo_de_contagem'] ?? '-' ?></td>

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <!-- Editar -->
                                            <button class="btn btn-sm btn-primary btn-edicao" data-bs-toggle="modal"
                                                data-bs-target="#exercicio_modal_editar"
                                                data-selecionado='<?= json_encode($e) ?>'
                                                data-opcoes='<?= json_encode(["Modo de contagem" => ["Contagem", "Tempo"]]) ?>'>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Excluir -->
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#tipo_exercicio_modal_excluir"
                                                data-selecionado="<?= json_encode($e) ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Nenhum exercício encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Tabela -->
    </div>
    </div>

    <!-- Script de Validação Bootstrap -->
    <?php $this->load->view('templates/validator_form'); ?>
</section>