<section class="content">
    <div class="container-fluid">


        <?php $this->load->view('templates/modal_generico_edicao', ['nome_modal' => 'Segurança', 'endpoint' => 'Seguranca/editar_login', 'campos' => ['Nome|', 'Nível|Select', 'Email|']]); ?>
        <?php $this->load->view('templates/modal_excluir/seguranca_modal', ['id' => 'seguranca_modal_excluir']); ?>

        <?php
        $alert_type = $this->session->flashdata('alert_type');
        $alert_message = $this->session->flashdata('alert_message');
        $usuarios_options = array_para_select($usuarios, 'id', 'nome');

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
            <h3>Adicionar Logins</h3>
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
                    'pattern' => "^[^\s@]+@[^\s@]+\.[^\s@]{2,}$",
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
                <?php
                $this->load->view('templates/inputs/input_select', [
                    'id' => 'nivel',
                    'title' => 'Nível',
                    'placeholder' => 'Selecione o nível',
                    'options' => ['Administrador', 'Avaliador', 'Atleta'],
                ]);
                ?>

                <!-- Usuário -->
                <?php
                $this->load->view('templates/inputs/input_select', [
                    'id' => 'usuario_id',
                    'title' => 'Nome do usuário',
                    'placeholder' => 'Selecione um usuário',
                    'options' => $usuarios_options,
                ]);
                ?>

                <button type="submit" class="btn btn-primary me-1">Novo Login</button>
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
                            <th>Email</th>
                            <th>Nível</th>
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
                        if (!empty($logins)):
                            foreach ($logins as $key => $l):
                                ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $l['email'] ?></td>
                                    <td><?= $l['nivel'] ?></td>
                                    <td><?= $l['matricula'] ?? '-'; ?></td>
                                    <td><?= $l['nome'] ?? '-'; ?></td>
                                    <td><?= formata_data_nascimento($l['data_nascimento']) ?? '-'; ?></td>
                                    <td><?= coletar_idade($l['data_nascimento']) . ' anos' ?? '-'; ?></td>
                                    <td><?= $l['sexo'] ?? '-'; ?>
                                        <?php if ($l['sexo'] == "Masculino"): ?>
                                            <i class="fa-solid fa-mars bg-info p-2 rounded text-white"></i>
                                        <?php elseif ($l['sexo'] == 'Feminino'): ?>
                                            <i class="fa-solid fa-venus bg-danger p-2 rounded text-white"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn btn-sm btn-primary btn-edicao" data-bs-toggle="modal"
                                                data-bs-target="#seguranca_modal_editar"
                                                data-selecionado='<?= json_encode($l) ?>'
                                                data-opcoes='<?= json_encode(["Nível"=>["Administrador","Avaliador","Atleta"]]) ?>'>
                                                <i class="fas fa-edit"></i>
                                            </button>


                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#seguranca_modal_excluir"
                                                data-selecionado='<?= json_encode($l) ?>'>
                                                <i class="fas fa-trash"></i>
                                            </button>
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