<section class="content">
    <div class="container-fluid">
        <?php
        $this->load->view('templates/small_box', [
            'color' => 'bg-info',
            'value' => count($usuarios),
            'title' => 'Usuários',
            'icon' => 'fa-solid fa-user'
        ]);
        ?>

        <h3>Adicionar Usuários</h3>

        <div class="col-md-6">
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
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                            <td><?= $u['nome'] ?? '-'; ?></td>
                                            <td><?= formata_data_nascimento($u['data_nascimento']) ?? '-'; ?></td>
                                            <td><?= coletar_idade($u['data_nascimento']) . ' anos' ?? '-'; ?></td>
                                            <td><?= $u['sexo'] ?? '-'; ?></td>
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