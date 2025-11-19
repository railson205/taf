<section class="content">
    <div class="container-fluid">

        <?php $this->load->view('templates/modal_edicao/seguranca_modal', ['id' => 'seguranca_modal_editar']); ?>
        <?php $this->load->view('templates/modal_excluir/seguranca_modal', ['id' => 'seguranca_modal_excluir']); ?>

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
            <form method="POST" action="<?= site_url("Seguranca/adicionar_login") ?>" class="needs-validation"
                novalidate>

                <!-- Email -->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'email',
                    'title' => 'Email',
                    'placeholder' => 'Seu Email',
                    'type' => 'text',
                    'minlength' => 3,
                    'maxlength' => 50,
                    'pattern' => "^[A-Za-zÀ-ÿ]+(?:\s+[A-Za-zÀ-ÿ]+)+$"
                ]);
                ?>

                <!-- Senha -->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'senha',
                    'title' => 'Senha',
                    'placeholder' => 'Sua senha',
                    'type' => 'text',
                    'minlength' => 6,
                ]);
                ?>

                <!-- Nível de segurança -->
                

                <!-- Usuário -->
               

                <button type="submit" class="btn btn-primary me-1">Novo Login</button>
            </form>
        </div>
        <!--Form-->

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
                                    <th>Matrícula</th>
                                    <th>Nome</th>
                                    <th>Data de nascimento</th>
                                    <th>Idade</th>
                                    <th>Sexo</th>
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
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
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