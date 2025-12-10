<section class="content">
    <div class="container-fluid">
        <?php
        $this->load->view('templates/small_box', [
            'color' => 'bg-success',
            'value' => count($faixas_etarias),
            'title' => 'Faixas Etárias',
            'icon' => 'fa-solid fa-calendar'
        ]);
        ?>

        <?php $this->load->view('templates/modal_edicao/faixa_modal', ['id' => 'faixa_modal_editar']); ?>
        <?php $this->load->view('templates/modal_excluir/faixa_modal', ['id' => 'faixa_modal_excluir']); ?>
        
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
            <h3>Adicionar Faixa Etária</h3>
            <!--Form-->
            <form method="POST" action="<?= site_url("FaixasEtarias/adicionar_faixa_etaria") ?>"
                class="needs-validation" novalidate>

                <!-- Nome do Grupo -->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'nome_grupo',
                    'title' => 'Nome do grupo',
                    'placeholder' => 'Ex.: Grupo 1',
                    'type' => 'text',
                    'icon_span' => 'abc',
                    'minlength' => 3,
                    'maxlength' => 50,
                ]);
                ?>

                <!-- Idade Inicial -->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'idade_i',
                    'title' => 'Idade inicial',
                    'placeholder' => 'Idade inicial da faixa',
                    'type' => 'number',
                    'icon_span' => '<i class="fa-solid fa-calendar"></i>',
                    'min' => '18'
                ]);
                ?>

                <!-- Idade Final -->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'idade_f',
                    'title' => 'Idade final',
                    'placeholder' => 'Idade final da faixa',
                    'type' => 'number',
                    'icon_span' => '<i class="fa-solid fa-calendar"></i>',
                    'min' => '18'
                ]);
                ?>

                <button type="submit" class="btn btn-primary me-1">Nova Faixa Etária</button>
            </form>
        </div>
        <!--Form-->
        <!--Tabela -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h5>Usuários</h5>
                <table class="table table-striped table-hover table-bordered datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome do grupo</th>
                                    <th>Idade Inicial</th>
                                    <th>Idade Final</th>
                                    <th>Faixa Etária</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($faixas_etarias)):
                                    foreach ($faixas_etarias as $key => $f):
                                        ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $f['nome_grupo'] ?? '-' ?></td>
                                            <td><?= $f['idade_inicial'] . ' anos' ?? '-' ?></td>
                                            <td><?= $f['idade_final'] . ' anos' ?? '-' ?></td>
                                            <td><?= $f['faixa_etaria'] ?? '-' ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#faixa_modal_editar" data-id="<?= $f['id'] ?>"
                                                    data-nome="<?= $f['nome_grupo'] ?>"
                                                    data-idade-inicial="<?= $f['idade_inicial'] ?>"
                                                    data-idade-final="<?= $f['idade_final'] ?>">
                                                    <i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#faixa_modal_excluir" data-id="<?= $f['id'] ?>"
                                                    data-nome="<?= $f['nome_grupo'] ?>"
                                                    data-idade-inicial="<?= $f['idade_inicial'] ?>"
                                                    data-idade-final="<?= $f['idade_final'] ?>"><i
                                                    class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">Nenhuma faixa etária encontrada.</td>
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

    <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 5,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json"
                },
                columnDefs: [
                    { orderable: false, targets: -1 } // Ações não ordena
                ]
            });
        });
    </script>
    <!-- Script de Validação Bootstrap -->
    <?php $this->load->view('templates/validator_form'); ?>
</section>