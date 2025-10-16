<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Tabela TAF</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
        }

        .main {
            display: flex;
            align-items: center;
            min-height: 100vh;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .div_row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .container_usuarios,
        .container_feixa_etaria {
            margin-bottom: 3rem;
        }

        h3 {
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <main class="main">
        <div class="container">
            <div class="row justify-content-center">
                <a class="btn btn-primary btn-lg" href=<?= site_url('Home/mocar_tabela') ?>>Adicionar notas na Tabela</a>

                <!-- FORMULÁRIO DE USUÁRIOS -->
                <div class="container_usuarios">
                    <div class="body">
                        <h3>Digite suas informações</h3>
                        <form method="POST" action="<?= site_url('Home/inserir_usuario') ?>">
                            <div class="div_row">
                                <?= input_component('Nome:', 'nome', 'text', 'Insira um nome válido', 'Exemplo: Seu Nome', '', '', 'pattern="^\S+\s+\S+.*$"'); ?>
                                <?= input_component('Data de nascimento:', 'data_nascimento', 'date', 'Insira uma data de nascimento válida'); ?>
                                <?= input_component('Sexo:', 'sexo', 'select', 'Selecione um sexo válido', '', ['Masculino', 'Feminino']); ?>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">Adicionar</button>
                            </div>
                        </form>
                    </div>

                    <!-- TABELA DE faixa etária -->
                    <div style="width: 100%; max-height: 800px; overflow: auto;">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>Data de Nascimento</th>
                                    <th>Idade</th>
                                    <th>Sexo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($usuarios)):
                                    foreach ($usuarios as $usuario):
                                        $d_nasc = new DateTime($usuario['data_nascimento']);
                                        $idade = (date('Y') - $d_nasc->format('Y')) - 1;
                                        ?>
                                        <tr>
                                            <td><?= $usuario['nome']; ?></td>
                                            <td><?= $d_nasc->format('d/m/Y'); ?></td>
                                            <td><?= $idade; ?></td>
                                            <td><?= $usuario['sexo']; ?></td>
                                            <td>
                                                <a href="<?= base_url('usuarios/editar/' . $usuario['id']); ?>"
                                                    class="btn btn-warning btn-sm">Editar</a>
                                                <a href="<?= base_url('usuarios/excluir/' . $usuario['id']); ?>"
                                                    class="btn btn-danger btn-sm">Excluir</a>
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

                <!-- FORMULÁRIO DE FAIXAS ETÁRIAS -->
                <div class="container_faixa_etaria">
                    <div class="body">
                        <h3>Digite as faixas etárias</h3>
                        <form method="POST" action="<?= site_url('Home/inserir_faixa_etaria') ?>">
                            <div class="div_row">
                                <?= input_component('Idade inicial(somente número):', 'idade_i', 'number', 'Insira uma idade inicial'); ?>
                                <?= input_component('Idade final(somente número):', 'idade_f', 'number', 'Insira uma idade final'); ?>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">Adicionar</button>
                            </div>
                        </form>
                    </div>

                    <!-- TABELA DE USUÁRIOS -->
                    <div style="width: 100%; max-height: 800px; overflow: auto;">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-dark">
                                <tr>

                                    <th>Idade Inicial</th>
                                    <th>Idade Final</th>
                                    <th>Faixa Etária</th>
                                    <th>Ações</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($faixas_etarias)):
                                    $faixas_etarias = organizar_array($faixas_etarias, 'faixa');
                                    foreach ($faixas_etarias as $idades):
                                        ?>
                                        <tr>
                                            <td><?= $idades['idade_inicial']; ?></td>
                                            <td><?= $idades['idade_final']; ?></td>
                                            <td><?= $idades['faixa'];
                                            ?></td>
                                            <td>
                                                <a href="<?= base_url('usuarios/editar/' . $usuario['id']); ?>"
                                                    class="btn btn-warning btn-sm">Editar</a>
                                                <a href="<?= base_url('usuarios/excluir/' . $usuario['id']); ?>"
                                                    class="btn btn-danger btn-sm">Excluir</a>
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
                <!-- FORMULÁRIO DE Exercícios -->
                <div class="container_exercicios">
                    <div class="body">
                        <h3>Registre os exercícios</h3>
                        <form method="POST" action="<?= site_url('Home/inserir_resultado') ?>">
                            <?php
                            $nomes = [];
                            $nomes_id = [];
                            foreach ($usuarios as $user) {
                                $nomes[] = $user['nome'];
                                $nomes_id[] = $user['id'];
                            }
                            ?>
                            <div class="div_row">
                                <?= input_component("Nome:", 'usuario_id', 'select', 'Selecione um nome.', '', $nomes, $nomes_id) ?>
                                <?= input_component("Corrida 2400m (Minutos:Segundos):", 'corrida_2400m', 'time', 'Insira um tempo válido.', 'Exemplo: 12:00', [], [], "pattern='^(?:[01]\d|2[0-3]):[0-5]\d$'", ) ?>
                                <?= input_component("Flexão Abdominal Supra:", 'flexao_abdominal_supra', 'number', 'Insira uma quantidade válida.', 'Exemplo: 10') ?>
                                <?= input_component("Flexão Dinâmica de Braço na Barra Fixa:", 'flexao_barra_fixa', 'number', 'Insira uma quantidade válida.', 'Exemplo: 10') ?>
                                <?= input_component("Natação 100m(Minutos:Segundos):", 'natacao_100m', 'time', 'Insira um tempo válido.', 'Exemplo: 12:00', [], "pattern='^(?:[01]\d|2[0-3]):[0-5]\d$'", ) ?>
                                <?= input_component("Flexão de Braço no Solo:", 'flexao_braco_solo', 'number', 'Insira uma quantidade válida.', 'Exemplo: 10') ?>
                                <?= input_component("Natação 12 min(Metros):", 'natacao_12min', 'number', 'Insira uma quantidade válida.', 'Exemplo: 10') ?>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">Adicionar</button>
                            </div>
                        </form>
                    </div>

                    <!-- TABELA DE Exercícios -->
                    <div style="width: 100%; max-height: 800px; overflow: auto;">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>Faixa Etária</th>
                                    <th>Sexo</th>
                                    <th>Corrida 2400m</th>
                                    <th>Flexão Abdominal Supra</th>
                                    <th>Flexão Dinâmica de Braço na Barra Fixa</th>
                                    <th>Natação 100m</th>
                                    <th>Flexão de Braço no Solo</th>
                                    <th>Natação 12 min</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($exercicios)):
                                    foreach ($exercicios as $e):
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($e['nome']) ?></td>
                                            <td><?= $e['faixa'] ?? '-' ?> anos</td>
                                            <td><?= $e['sexo'] ?? '-' ?></td>
                                            <td><?= $e['corrida_2400m'] ?? '-' ?></td>
                                            <td><?= $e['flexao_abdominal_supra'] ?? '-' ?></td>
                                            <td><?= $e['flexao_barra_fixa'] ?? '-' ?></td>
                                            <td><?= $e['natacao_100m'] ?? '-' ?></td>
                                            <td><?= $e['flexao_braco_solo'] ?? '-' ?></td>
                                            <td><?= $e['natacao_12min'] ?? '-' ?></td>
                                            <td>
                                                <a href="<?= base_url('resultados/editar/' . $e['id']) ?>"
                                                    class="btn btn-warning btn-sm">Editar</a>
                                                <a href="<?= base_url('resultados/excluir/' . $e['id']) ?>"
                                                    class="btn btn-danger btn-sm">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9">Nenhum resultado cadastrado.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- FORMULÁRIO DE Notas -->
                <div class="container_notas">
                    <div class="body">
                        <h3>Registre as notas</h3>
                        <form method="POST" action="<?= site_url('Home/inserir_notas') ?>">
                            <?php
                            foreach ($faixas_etarias as $faixa) {
                                $faixas_etarias_options[] = strval($faixa['idade_inicial']) . '-' . strval($faixa['idade_final']);
                                $faixas_etarias_options_id[] = $faixa['id'];
                            }

                            ?>
                            <div class="div_row">
                                <?= input_component("Faixa Etária:", 'faixa_etaria_id', 'select', 'Selecione um nome.', '', $faixas_etarias_options, $faixas_etarias_options_id) ?>
                                <?= input_component('Sexo:', 'sexo', 'select', 'Selecione um sexo válido', '', ['Masculino', 'Feminino']); ?>
                                <?= input_component("Nota:", 'nota', 'float', 'Selecione um nome.') ?>
                                <?= input_component("Corrida 2400m (Minutos:Segundos):", 'corrida_2400m', 'time', 'Insira um tempo válido.', 'Exemplo: 12:00', [], [], "pattern='^(?:[01]\d|2[0-3]):[0-5]\d$'", ) ?>
                                <?= input_component("Flexão Abdominal Supra:", 'flexao_abdominal_supra', 'number', 'Insira uma quantidade válida.', 'Exemplo: 10') ?>
                                <?= input_component("Flexão Dinâmica de Braço na Barra Fixa:", 'flexao_barra_fixa', 'number', 'Insira uma quantidade válida.', 'Exemplo: 10') ?>
                                <?= input_component("Natação 100m(Minutos:Segundos):", 'natacao_100m', 'time', 'Insira um tempo válido.', 'Exemplo: 12:00', [], "pattern='^(?:[01]\d|2[0-3]):[0-5]\d$'", ) ?>
                                <?= input_component("Flexão de Braço no Solo:", 'flexao_braco_solo', 'number', 'Insira uma quantidade válida.', 'Exemplo: 10') ?>
                                <?= input_component("Natação 12 min(Metros):", 'natacao_12min', 'number', 'Insira uma quantidade válida.', 'Exemplo: 10') ?>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">Adicionar</button>
                            </div>
                        </form>
                    </div>

                    <!-- TABELA DE Notas -->
                    <div style="width: 100%; max-height: 800px; overflow: auto;">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Faixa Etária</th>
                                    <th>Sexo</th>
                                    <th>Nota</th>
                                    <th>Corrida 2400m</th>
                                    <th>Flexão Abdominal Supra</th>
                                    <th>Flexão Dinâmica de Braço na Barra Fixa</th>
                                    <th>Natação 100m</th>
                                    <th>Flexão de Braço no Solo</th>
                                    <th>Natação 12 min</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($notas)):
                                    $notas = organizar_array($notas, 'faixa', SORT_ASC, 'nota', SORT_ASC);
                                    foreach ($notas as $n):
                                        ?>
                                        <tr>
                                            <td><?= $n['faixa'] ?? '-' ?> anos</td>
                                            <td><?= $n['sexo'] ?? '-' ?></td>
                                            <td><?= $n['nota'] ?? '-' ?></td>
                                            <td><?= $n['corrida_2400m'] ?? '-' ?></td>
                                            <td><?= $n['flexao_abdominal_supra'] ?? '-' ?></td>
                                            <td><?= $n['flexao_barra_fixa'] ?? '-' ?></td>
                                            <td><?= $n['natacao_100m'] ?? '-' ?></td>
                                            <td><?= $n['flexao_braco_solo'] ?? '-' ?></td>
                                            <td><?= $n['natacao_12min'] ?? '-' ?></td>
                                            <td>
                                                <a href="<?= base_url('resultados/editar/' . $e['id']) ?>"
                                                    class="btn btn-warning btn-sm">Editar</a>
                                                <a href="<?= base_url('resultados/excluir/' . $e['id']) ?>"
                                                    class="btn btn-danger btn-sm">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9">Nenhum resultado cadastrado.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class='container-notas'>
                    <h3>Resultados</h3>
                    <a class="btn btn-primary btn-lg" href=<?= site_url('Home/atualizar_resultados') ?>>Atualizar
                        Notas</a>
                    <!-- TABELA DE resultados) -->
                    <div style="width: 100%; max-height: 800px; overflow: auto;">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>Faixa Etária</th>
                                    <th>Sexo</th>
                                    <th>Corrida 2400m</th>
                                    <th>Flexão Abdominal Supra</th>
                                    <th>Flexão Dinâmica de Braço na Barra Fixa</th>
                                    <th>Natação 100m</th>
                                    <th>Flexão de Braço no Solo</th>
                                    <th>Natação 12 min</th>
                                    <th>Nota Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($resultados)):
                                    foreach ($resultados as $e): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($e['nome']) ?></td>
                                            <td><?= $e['faixa'] ?> anos</td>
                                            <td><?= $e['sexo'] ?></td>
                                            <td><?= $e['corrida_2400m'] ?? '-' ?></td>
                                            <td><?= $e['flexao_abdominal_supra'] ?? '-' ?></td>
                                            <td><?= $e['flexao_barra_fixa'] ?? '-' ?></td>
                                            <td><?= $e['natacao_100m'] ?? '-' ?></td>
                                            <td><?= $e['flexao_braco_solo'] ?? '-' ?></td>
                                            <td><?= $e['natacao_12min'] ?? '-' ?></td>
                                            <td><?= $e['nota_total'] ?? '-' ?></td>
                                            <td>
                                                <a href="<?= base_url('resultados/editar/' . $e['id']) ?>"
                                                    class="btn btn-warning btn-sm">Editar</a>
                                                <a href="<?= base_url('resultados/excluir/' . $e['id']) ?>"
                                                    class="btn btn-danger btn-sm">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9">Nenhum resultado cadastrado.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </main>
</body>

</html>