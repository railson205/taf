<section class="content">
    <div class="container-fluid">
        <?php
        $this->load->view('templates/small_box', [
            'color' => 'verde',
            'value' => count($usuarios),
            'title' => 'Usuários',
            'icon' => 'fa-solid fa-user'
        ]);
        ?>

        <?php $this->load->view('templates/modal_edicao/usuario_modal', ['id' => 'usuario_modal_editar']); ?>
        <?php $this->load->view('templates/modal_excluir/usuario_modal', ['id' => 'usuario_modal_excluir']); ?>

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
            <h3>Adicionar Usuários</h3>
            <!--Form-->
            <form method="POST" action="<?= site_url("Usuarios/adicionar_usuario") ?>" class="needs-validation"
                novalidate>

                <!-- Nome -->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'nome_usuario',
                    'title' => 'Nome',
                    'placeholder' => 'Seu Nome',
                    'type' => 'text',
                    'icon_span' => '<i class="fa-solid fa-user"></i>',
                    'minlength' => 3,
                    'maxlength' => 50,
                    'pattern' => "^[A-Za-zÀ-ÿ]+(?:\s+[A-Za-zÀ-ÿ]+)+$"
                ]);
                ?>

                <!-- Matrícula -->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'matricula',
                    'title' => 'Matrícula',
                    'placeholder' => 'Sua matrícula',
                    'type' => 'number',
                    'minlength' => 3,
                    'maxlength' => 50,
                ]);
                ?>

                <!-- Data de nascimento -->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'data_nasc_usuario',
                    'title' => 'Data de Nascimento',
                    'placeholder' => 'Sua data de nascimento',
                    'type' => 'date',
                    'icon_span' => '<i class="fa-solid fa-calendar"></i>',
                    'min' => '1900-01-01',
                    'max' => date('Y-m-d')
                ]);
                ?>

                <!-- Sexo -->
                <?php
                $this->load->view('templates/inputs/input_select', [
                    'id' => 'sexo_usuario',
                    'title' => 'Sexo',
                    'placeholder' => 'Selecione seu sexo',
                    'options' => ['Masculino', 'Feminino'],
                ]);
                ?>

                <button type="submit" class="btn btn-primary me-1">Novo Usuário</button>
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
                            <th>Matrícula</th>
                            <th>Nome</th>
                            <th>Data de nascimento</th>
                            <th>Idade</th>
                            <th>Sexo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($usuarios)):
                            foreach ($usuarios as $key => $u):
                                ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $u['matricula'] ?? '-'; ?></td>
                                    <td><?= $u['nome'] ?? '-'; ?></td>
                                    <td><?= formata_data_nascimento($u['data_nascimento']) ?? '-'; ?></td>
                                    <td><?= coletar_idade($u['data_nascimento']) . ' anos' ?? '-'; ?></td>
                                    <td><?= $u['sexo'] ?? '-'; ?>
                                        <?php if ($u['sexo'] == "Masculino"): ?>
                                            <i class="fa-solid fa-mars bg-info p-2 rounded text-white"></i>
                                        <?php elseif ($u['sexo'] == 'Feminino'): ?>
                                            <i class="fa-solid fa-venus bg-danger p-2 rounded text-white"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn btn-sm btn-primary btn-edicao btn-edicao" data-bs-toggle="modal"
                                                data-bs-target="#usuario_modal_editar" data-id="<?= $u['id'] ?>"
                                                data-nome="<?= $u['nome'] ?>" data-matricula="<?= $u['matricula'] ?>"
                                                data-data-nascimento="<?= $u['data_nascimento'] ?>"
                                                data-sexo-selecionado="<?= $u['sexo'] ?>"
                                                data-sexo-options="Masculino,Feminino">
                                                <i class="fas fa-edit"></i></button>

                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#usuario_modal_excluir" data-id="<?= $u['id'] ?>"
                                                data-nome="<?= $u['nome'] ?>" data-matricula="<?= $u['matricula'] ?>"
                                                data-data-nascimento="<?= $u['data_nascimento'] ?>"
                                                data-sexo="<?= $u['sexo'] ?>"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
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
    <!--Tabela -->
    </div>
    </div>

    <!-- Script de Validação Bootstrap -->
    <?php $this->load->view('templates/validator_form'); ?>
</section>