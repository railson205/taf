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

        .h3 {
            margin-bottom: 1.5rem;
        }

        .th-center {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>

<body>
    <main class="main">
        <div class="container">
            <div class="row justify-content-center">

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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($usuarios)):
                                    foreach ($usuarios as $data):
                                        ?>
                                        <tr>
                                            <td><?= $data['nome'] ?? '-'; ?></td>
                                            <td><?= formata_data_nascimento($data['data_nascimento']) ?? '-'; ?></td>
                                            <td><?= coletar_idade($data['data_nascimento']) ?? '-'; ?></td>
                                            <td><?= $data['sexo'] ?? '-'; ?></td>
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
                                <?= input_component('Nome do grupo:', 'nome_grupo', 'text', 'Insira um nome de grupo', 'Ex:grupo 1'); ?>
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
                                    <th>Nome do grupo</th>
                                    <th>Idade Inicial</th>
                                    <th>Idade Final</th>
                                    <th>Faixa Etária</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($faixas_etarias)):
                                    $faixas_etarias = organizar_array($faixas_etarias, 'idade_inicial');
                                    foreach ($faixas_etarias as $idades):
                                        $faixa = $idades['idade_inicial'] . '-' . $idades['idade_final'];
                                        ?>
                                        <tr>
                                            <td><?= $idades['nome_grupo'] ?? '-'; ?></td>
                                            <td><?= $idades['idade_inicial'] ?? '-'; ?></td>
                                            <td><?= $idades['idade_final'] ?? '-'; ?></td>
                                            <td><?= $faixa;
                                            ?></td>
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
                <!-- FORMULÁRIO DE adicionar Exercícios -->
                <div class="container_exercicios">
                    <div class="body">
                        <h3>Registre os exercícios</h3>
                        <form method="POST" action="<?= site_url('Home/inserir_registro_exercicio') ?>">

                            <div class="div_row">
                                <?= input_component('Nome do exercício:', 'nome_exercicio', 'text', 'Insira um nome para exercício') ?>
                                <?= input_component('Tipo do exercício:', 'tipo_exercicio', 'select', 'Selecione um tipo para exercício', '', ['Tempo', 'Contagem']) ?>
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
                                    <th>Nome do exercício</th>
                                    <th>Tipo do exercício</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tipos_exercicios)):
                                    foreach ($tipos_exercicios as $e):
                                        ?>
                                        <tr>
                                            <td><?= $e['nome_exercicio'] ?></td>
                                            <td><?= $e['tipo_exercicio'] ?></td>
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
                <!-- FORMULÁRIO DE Exercícios dos usuários -->
                <div class="container_exercicios_realizados">
                    <div class="body">
                        <h3>Registre os exercícios de cada usuário</h3>
                        <form method="POST" action="<?= site_url('Home/inserir_exercicio_usuario') ?>">
                            <?php
                            //Nomes de usuários
                            $nomes = array_column($usuarios, 'nome');
                            $nomes_id = array_column($usuarios, 'id');
                            //Nomes dos exercícios
                            $exercicios = array_column($tipos_exercicios, 'nome_exercicio');
                            $exercicios_tipos = array_column($tipos_exercicios, 'tipo_exercicio');
                            $exercicios_id = array_column($tipos_exercicios, 'exercicio_id');
                            ?>
                            <div class="div_row">
                                <?= input_component("Nome:", 'usuario_id', 'select', 'Selecione um nome.', '', $nomes, $nomes_id) ?>
                                <?= input_component("Exercício:", 'exercicio_id', 'select', 'Selecione um nome.', '', $exercicios, $exercicios_id) ?>
                                <?= input_component('Índice do exercício:', 'contagem_exercicio', 'select', '', '', [], [], 'disabled') ?>
                                <button type="button" class="btn btn-primary btn-lg"
                                    onclick="onChangeExerciciosUsuarios()">Mostrar
                                    índices</button>
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
                                    <th rowspan="2" class="th-center">Nome</th>
                                    <th rowspan="2" class="th-center">Sexo</th>
                                    <th rowspan="2" class="th-center">Idade</th>
                                    <th rowspan="2" class="th-center">Grupo da Faixa Etária</th>
                                    <th rowspan="2" class="th-center">Faixa Etária</th>
                                    <?php foreach ($exercicios_unicos_usuarios as $key => $ex): ?>
                                        <th colspan="3" style="border-right: 2px solid black; border-left: 2px solid black">
                                            Exercício <?= $key ?>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <?php foreach ($exercicios_unicos_usuarios as $ex): ?>
                                        <th style="border-left: 2px solid black">Nome</th>
                                        <th>Contagem</th>
                                        <th style="border-right: 2px solid black">Tipo de Contagem</th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($exercicios_realizados)):
                                    organizar_array($exercicios_realizados, 'nome');
                                    foreach ($exercicios_realizados as $data):
                                        ?>
                                        <tr>
                                            <td><?= $data['nome'] ?? '-' ?></td>
                                            <td><?= $data['sexo'] ?? '-' ?></td>
                                            <td><?= coletar_idade($data['data_nascimento']) ?? '-' ?> anos</td>
                                            <td><?= $data['grupo_faixa'] ?? '-' ?></td>
                                            <td><?= $data['faixa_etaria'] ?? '-' ?> anos</td>


                                            <?php
                                            // Mapeia os exercícios do usuário para facilitar acesso pelo nome
                                            $map_exercicios = [];
                                            foreach ($data['exercicios'] as $ex) {
                                                $map_exercicios[$ex['nome_exercicio']] = $ex;
                                            }

                                            foreach ($resultados_exercicios_unicos as $exercicio):
                                                $ex = $map_exercicios[$exercicio] ?? null;
                                                ?>
                                                <td style="border-left: 2px solid black"><?= $ex['nome_exercicio'] ?></td>
                                                <td><?= $ex['tipo_exercicio'] == 'Tempo' ? segundos_para_tempo($ex['contagem_exercicio']) . ' min' : $ex['contagem_exercicio'] ?>
                                                </td>
                                                <td style="border-rigth: 2px solid black"><?= $ex['tipo_exercicio'] ?></td>
                                            <?php endforeach; ?>
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
                        <form method="POST" action="<?= site_url('Home/inserir_notas_exercicios') ?>">
                            <?php
                            $faixas_etarias_options = array_map(function ($f) {
                                return $f['idade_inicial'] . '-' . $f['idade_final'];
                            }, $faixas_etarias);
                            $faixas_etarias_options_id = array_column($faixas_etarias, 'id');
                            $notas_options = array_map(function ($f) {
                                return $f;
                            }, range(0.5, 10, 0.5));
                            $exercicios_options = array_column($tipos_exercicios, 'nome_exercicio');
                            $exercicios_options_id = array_column($tipos_exercicios, 'exercicio_id');
                            ?>
                            <div class="div_row">
                                <?= input_component("Faixa Etária:", 'faixa_etaria_id_nota', 'select', 'Selecione um nome.', '', $faixas_etarias_options, $faixas_etarias_options_id) ?>
                                <?= input_component('Sexo:', 'sexo_nota', 'select', 'Selecione um sexo válido', '', ['Masculino', 'Feminino']); ?>
                                <?= input_component("Nota:", 'nota', 'select', 'Selecione uma nota.', '', $notas_options) ?>
                                <!-- Modificar os inputs de exercícios e meta-->
                                <?= input_component("Exercício:", 'exercicio_nota', 'select', 'Selecione uma nota.', '', $exercicios_options, $exercicios_options_id, 'onChange="onChangeExerciciosNota()"') ?>
                                <?= input_component('Meta:', 'meta_nota', 'number', '', '', '', '', 'disabled') ?>
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
                                    <th>Grupo da Faixa Etária</th>
                                    <th>Faixa Etária</th>
                                    <th>Sexo</th>
                                    <th>Nota</th>
                                    <th>Nome do Exercício</th>
                                    <th>Tipo de Contagem do Exercício</th>
                                    <th>Meta do Exercício</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($notas_exercicios)):
                                    $notas = organizar_array($notas_exercicios, 'faixa_etaria', SORT_ASC, 'valor_nota', SORT_ASC);
                                    foreach ($notas_exercicios as $n):
                                        ?>
                                        <tr>
                                            <td><?= $n['grupo_faixa_etaria'] ?? '-' ?></td>
                                            <td><?= $n['faixa_etaria'] ?? '-' ?> anos</td>
                                            <td><?= $n['sexo'] ?? '-' ?></td>
                                            <td><?= $n['valor_nota'] ?? '-' ?></td>
                                            <td><?= $n['nome_exercicio'] ?? '-' ?></td>
                                            <td><?= $n['tipo_exercicio'] ?? '-' ?></td>
                                            <td><?= $n['tipo_exercicio'] == 'Tempo' ? segundos_para_tempo($n['meta_exercicio']) . ' min' : $n['meta_exercicio'] ?? '-' ?>
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
                <!-- TABELA DE resultados -->
                <div class='container-resultados'>
                    <h3>Resultados</h3>
                    <div style="width: 100%; max-height: 800px; overflow: auto;">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th rowspan="2" class="th-center">Nome</th>
                                    <th rowspan="2" class="th-center">Sexo</th>
                                    <th rowspan="2" class="th-center">Faixa Etária</th>
                                    <th rowspan="2" class="th-center">Grupo Faixa</th>
                                    <?php foreach ($resultados_exercicios_unicos as $exercicio): ?>
                                        <th colspan="4" style="border-right: 2px solid black; border-left: 2px solid black">
                                            <?= htmlspecialchars($exercicio) ?>
                                        </th>
                                    <?php endforeach; ?>
                                    <th rowspan="2" class="th-center">Nota Final</th>
                                </tr>
                                <tr>

                                    <?php foreach ($resultados_exercicios_unicos as $exercicio): ?>
                                        <th style="border-left: 2px solid black">Tipo</th>
                                        <th>Nota</th>
                                        <th>Meta</th>
                                        <th style="border-right: 2px solid black">Contagem</th>
                                    <?php endforeach; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados as $data): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($data['nome']) ?></td>
                                        <td><?= htmlspecialchars($data['sexo']) ?></td>
                                        <td><?= htmlspecialchars($data['faixa_etaria']) ?></td>
                                        <td style="border-right: 2px solid black">
                                            <?= htmlspecialchars($data['grupo_faixa']) ?>
                                        </td>

                                        <?php
                                        // Mapeia os exercícios do usuário para facilitar acesso pelo nome
                                        $map_exercicios = [];
                                        foreach ($data['exercicios'] as $ex) {
                                            $map_exercicios[$ex['nome_exercicio']] = $ex;
                                        }

                                        foreach ($resultados_exercicios_unicos as $exercicio):
                                            $ex = $map_exercicios[$exercicio] ?? null;
                                            ?>
                                            <td><?= $ex['tipo_exercicio'] ?? '-' ?></td>
                                            <td><?= $ex['valor_nota'] ?? '-' ?></td>
                                            <td><?= $ex['tipo_exercicio'] == 'Tempo' ? segundos_para_tempo($ex['meta_exercicio']) . ' min' : $ex['meta_exercicio'] ?? '-' ?>
                                            </td>
                                            <td style="border-right: 2px solid black">
                                                <?= $ex['tipo_exercicio'] == 'Tempo' ? segundos_para_tempo($ex['contagem_exercicio']) . ' min' : $ex['contagem_exercicio'] ?? '-' ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <td><?= $data['nota_final'] ?? '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>


                    </div>
                </div>


            </div>
        </div>
        <script>
            const tipos_exercicios = <?= json_encode($tipos_exercicios) ?>;
            const notas_exercicios = <?= json_encode($notas_exercicios) ?>;
            const usuarios = <?= json_encode($usuarios) ?>;

            function onChangeExerciciosUsuarios() {
                const campo_usuario_id = document.getElementById('inputUsuario_id');
                const usuario_selecionado = usuarios.find(u => u.id === String(campo_usuario_id.value));

                const campo_exercicio_id = document.getElementById('inputExercicio_id');
                const exercicio_selecionado = tipos_exercicios.find(e => e.exercicio_id === String(campo_exercicio_id.value));


                const campo_contagem = document.getElementById('inputContagem_exercicio');

                if (!exercicio_selecionado || !usuario_selecionado) {
                    campo_contagem.disabled = true;
                    campo_contagem.placeholder = '';
                    return;
                }

                const tipo_exercicio = exercicio_selecionado.tipo_exercicio;


                const notas_selecionadas = notas_exercicios.filter(e => {
                    const idade_usuario = new Date().getFullYear() - new Date(usuario_selecionado.data_nascimento).getFullYear();
                    const [idade_min, idade_max] = e.faixa_etaria.split('-').map(Number);

                    return e.exercicio_id == exercicio_selecionado.exercicio_id && e.sexo == usuario_selecionado.sexo && idade_min <= idade_usuario && idade_usuario <= idade_max;
                });



                if (notas_selecionadas.length == 0) {
                    campo_contagem.disabled = true;
                    campo_contagem.placeholder = '';
                    return;
                } else {
                    campo_contagem.innerHTML = '';
                    const notas = notas_selecionadas.map(e => e.valor_nota);
                    const indices = notas_selecionadas.map(e => e.meta_exercicio);
                    campo_contagem.disabled = false;


                }
            }

            function onChangeExerciciosNota() {
                const campo_id = document.getElementById('inputExercicio_nota');
                const campo_contagem = document.getElementById('inputMeta_nota');

                //Procura no array qual objeto com a key id tem o mesmo valor de campo.value
                const exercicio = tipos_exercicios.find(e => e.exercicio_id === String(campo_id.value));
                if (!exercicio) {
                    campo_contagem.disabled = true;
                    campo_contagem.placeholder = '';
                    return;
                }

                const tipo_exercicio = exercicio.tipo_exercicio;


                campo_contagem.removeEventListener('input', aplicarMascaraTempo);

                if (tipo_exercicio === 'Tempo') {
                    campo_contagem.type = 'text';
                    campo_contagem.icon = 'bi-stopwatch';
                    campo_contagem.placeholder = 'mm:ss';
                    campo_contagem.disabled = false;
                    campo_contagem.addEventListener('input', aplicarMascaraTempo);
                }
                else if (tipo_exercicio === 'Contagem') {
                    campo_contagem.type = 'float';
                    campo_contagem.placeholder = 'Digite a contagem';
                    campo_contagem.disabled = false;
                }
                else {
                    campo_contagem.type = 'text';
                    campo_contagem.placeholder = '';
                    campo_contagem.disabled = true;
                }
            }

            

            function adicionar_nova_nota() {

                const select_nota = document.getElementById('inputNota');
                const input_nova_nota = document.getElementById('inputNova_nota');

                const valor = input_nova_nota.value;

                //Verifica se é um valor e se está entre 0 e 10
                if (!isNaN(valor) && valor >= 0 && valor <= 10) {
                    const exists = Array.from(select_nota.options).some(opt => parseFloat(opt.value) == valor);
                    //Verifica se ja existe esse valor no array
                    if (!exists) {
                        const option = document.createElement('option');
                        option.value = valor;
                        option.text = valor;
                        select_nota.appendChild(option);
                        input_nova_nota.value = '';
                    } else {
                        alert('Essa nota ja existe');
                    }
                } else {
                    alert('Digite um valor entre 0 e 10');
                }
            }


        </script>
    </main>
</body>

</html>