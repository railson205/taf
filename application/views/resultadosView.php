<section class="content">
    <div class="container-fluid">
        <?php

        $qtdResultados = 0;
        foreach ($resultados['registro_exercicios'] as $registro) {
            $qtdResultados += count($registro['exercicios']);
        }
        $this->load->view('templates/small_box', [
            'color' => 'bg-info',
            'value' => $qtdResultados,
            'title' => 'Resultados',
            'icon' => 'fa-solid fa-person-swimming'
        ]);
        $usuarios_options = array_para_select($usuarios, 'id', 'nome');
        $exercicios_options = array_para_select($tipos_exercicios, 'id', 'nome_exercicio');

        $indices_options = array_para_select($notas, 'id', 'indice');
        $indices_id_options = array_para_select($notas, 'id', ['indice', 'exercicio_id']);
        $ex_unic = $resultados['exercicios_unicos_usuarios'];
        ?>

        <?php $this->load->view('templates/modal_edicao/resultados_modal', ['id' => 'resultados_modal_editar']); ?>
        <?php $this->load->view('templates/modal_excluir/resultados_modal', ['id' => 'resultados_modal_excluir']); ?>

        <?php
        $alert_type = $this->session->flashdata('alert_type');
        $alert_message = $this->session->flashdata('alert_message');

        if ($alert_message): ?>
            <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i> <?= $alert_message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="col-md-6">
            <h3>Adicionar Exercícios</h3>
            <!--Form-->
            <form method="POST" action="<?= site_url("Resultados/adicionar_resultados") ?>" class="needs-validation"
                novalidate>


                <!-- Usuário-->
                <?php
                $this->load->view('templates/inputs/input_select', [
                    'id' => 'usuario_id',
                    'title' => 'Nome do usuário',
                    'placeholder' => 'Selecione um usuário',
                    'options' => $usuarios_options,
                ]);
                ?>

                <!-- Nome do Exercício -->
                <?php
                $this->load->view('templates/inputs/input_select', [
                    'id' => 'exercicio_id',
                    'title' => 'Nome do Exercício',
                    'placeholder' => 'Escolha um exercício',
                    'options' => $exercicios_options,
                ]);
                ?>

                <!-- Índice da nota-->
                <?php
                $this->load->view('templates/inputs/input_select', [
                    'id' => 'nota_id',
                    'title' => 'Índice da Nota',
                    'placeholder' => 'Selecione um índice',
                    'options' => $indices_options,
                    'disabled' => true,
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
                                    <th rowspan="2" class="text-center border-end border-top border-dark">#</th>
                                    <th rowspan="2" class="text-center border-end border-top border-dark">Nome</th>
                                    <th rowspan="2" class="text-center border-end border-top border-dark">Sexo</th>
                                    <th rowspan="2" class="text-center border-end border-top border-dark">Faixa Etária
                                    </th>
                                    <th rowspan="2" class="text-center border-end border-top border-dark">Grupo
                                        da<br>Faixa
                                        Etária</th>
                                    <?php foreach ($ex_unic as $exercicio): ?>
                                        <th colspan="4" class="text-center border-end border-dark bg-secondary text-white">
                                            <?= htmlspecialchars($exercicio) ?>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>

                                    <?php foreach ($ex_unic as $exercicio): ?>
                                        <th class="text-center border-end border-dark">Modo de Contagem</th>
                                        <th class="text-center border-end border-dark">Índice</th>
                                        <th class="text-center border-end border-dark">Nota</th>
                                        <th class="text-center border-end border-dark">Ação</th>
                                    <?php endforeach; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($resultados)):
                                    foreach ($resultados['registro_exercicios'] as $key => $r):
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td class="text-center"><?= $r['nome'] ?? '-' ?></td>
                                            <td class="text-center"><?= $r['sexo'] ?? '-' ?>
                                                <?php if ($r['sexo'] == "Masculino"): ?>
                                                    <i class="fa-solid fa-mars bg-info p-2 rounded text-white"></i>
                                                <?php elseif ($r['sexo'] == 'Feminino'): ?>
                                                    <i class="fa-solid fa-venus bg-danger p-2 rounded text-white"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center"><?= $r['faixa_etaria'] ?? '-' ?></td>
                                            <td class="text-center"><?= $r['grupo_faixa'] ?? '-' ?></td>

                                            <?php
                                            // Mapeia os exercícios do usuário para facilitar acesso pelo nome
                                            $map_exercicios = [];
                                            foreach ($r['exercicios'] as $ex) {
                                                $map_exercicios[$ex['nome_exercicio']] = $ex;
                                            }

                                            foreach ($ex_unic as $exercicio):
                                                $ex = $map_exercicios[$exercicio] ?? null;
                                                ?>
                                                <td class="text-center"><?= $ex['modo_contagem'] ?? '-' ?></td>
                                                <td class="text-center">
                                                    <?= $ex['modo_contagem'] == 'Tempo' ? segundos_para_tempo($ex['indice']) : $ex['indice'] ?? '-' ?>
                                                </td>
                                                <td class="text-center"><?= $ex['valor_nota'] ?? '-' ?></td>

                                                <td class="text-center">
                                                    <?php if ($ex): ?>
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#resultados_modal_editar" data-selecionado='<?= json_encode([
                                                                "id" => $r["id"],
                                                                "usuario_id" => $r['usuario_id'],
                                                                "exercicio_id" => $ex["exercicio_id"],
                                                                "nota_id" => $ex['nota_id'],
                                                                'nome' => $r['nome'],
                                                                'sexo' => $r['sexo'],
                                                                'faixa' => $r['faixa_etaria'],
                                                                'grupo_faixa' => $r['grupo_faixa'],
                                                                'indice' => $ex['indice'],
                                                            ]) ?>' data-opcoes='<?= json_encode([
                                                                 'usuarios' => $usuarios_options,
                                                                 "exercicios" => $exercicios_options,
                                                                 'notas' => $indices_id_options,
                                                                 'all_exercicios' => $tipos_exercicios,
                                                             ]) ?>'>
                                                            <i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#resultados_modal_excluir" data-selecionado='<?= json_encode([
                                                                "id" => $r["id"],
                                                                "usuario_id" => $r['usuario_id'],
                                                                "exercicio_id" => $ex["exercicio_id"],
                                                                "nota_id" => $ex['nota_id'],
                                                                'nome' => $r['nome'],
                                                                'sexo' => $r['sexo'],
                                                                'faixa' => $r['faixa_etaria'],
                                                                'grupo_faixa' => $r['grupo_faixa'],
                                                                'indice' => $ex['indice'],
                                                            ]) ?>' data-opcoes='<?= json_encode([
                                                                 'usuarios' => $usuarios_options,
                                                                 "exercicios" => $exercicios_options,
                                                                 'notas' => $indices_id_options,
                                                                 'all_exercicios' => $tipos_exercicios,
                                                             ]) ?>'><i class="fas fa-trash"></i></button>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                            <?php endforeach; ?>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">Nenhum exercício realizado encontrado.</td>
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
        const notas = <?= json_encode($notas) ?>;
        const exercicios = <?= json_encode($tipos_exercicios) ?>;
        const usuarios = <?= json_encode($usuarios) ?>;
        const faixa = <?= json_encode($faixa) ?>;

        document.addEventListener('DOMContentLoaded', function () {
            const campo_exercicio = document.getElementById('exercicio_id');
            const campo_usuario = document.getElementById('usuario_id');

            if (campo_exercicio) {
                campo_exercicio.addEventListener('change', verificarIndices);
            }
            if (campo_usuario) {
                campo_usuario.addEventListener('change', verificarIndices);
            }
        });

        function verificarIndices() {
            const campo_exercicio = document.getElementById('exercicio_id');
            const campo_usuario = document.getElementById('usuario_id');

            const exercicioSelecionado = campo_exercicio?.value || '';
            const usuarioSelecionado = campo_usuario?.value || '';

            if (exercicioSelecionado && usuarioSelecionado) {
                const infoUsuario = usuarios.find(u => u.id === String(usuarioSelecionado));
                const infoExercicio = exercicios.find(e => e.id === String(exercicioSelecionado));



                const notasSelecionadas = notas.filter(n => {
                    const idade_usuario = new Date().getFullYear() - new Date(infoUsuario.data_nascimento).getFullYear();
                    const usuarioNaFaixa = faixa.find(f => f.id == n.faixa_id && parseInt(f.idade_inicial) <= idade_usuario && idade_usuario <= parseInt(f.idade_final));

                    return infoUsuario.sexo == n.sexo &&
                        infoExercicio.id == n.exercicio_id &&
                        usuarioNaFaixa
                }
                );

                const notasFiltradas = Object.values(
                    notasSelecionadas.reduce((acc, item) => {
                        const indice = item.indice;

                        // se ainda não existe esse indice ou se esse item tem valor maior, substitui
                        if (!acc[indice] || parseFloat(item.valor_nota) > parseFloat(acc[indice].valor_nota)) {
                            acc[indice] = item;
                        }
                        return acc;
                    }, {})
                );



                const campoNota = document.getElementById('nota_id');
                // Limpa o select antes de adicionar novas opções
                campoNota.innerHTML = '';

                // Se não encontrou notas, desabilita e mostra uma opção vazia
                if (!notasFiltradas.length) {
                    campoNota.disabled = true;
                    const opt = document.createElement('option');
                    opt.textContent = 'Nenhuma nota disponível';
                    opt.value = '';
                    campoNota.appendChild(opt);
                    return;
                }

                // Caso contrário, habilita e adiciona as opções
                campoNota.disabled = false;

                //Adiciona o placeholder
                const optBase = document.createElement('option')
                optBase.textContent = "Selecione um índice";
                optBase.value = "";
                campoNota.appendChild(optBase);

                notasFiltradas.forEach(nota => {
                    const opt = document.createElement('option');

                    opt.textContent = `${nota.modo_contagem == 'Tempo' ? seg_para_tempo(nota.indice) : nota.indice + ' repetições' ?? ''}`;
                    opt.value = nota.id;

                    campoNota.appendChild(opt);
                });
            }
        }

        function seg_para_tempo(segundos) {
            const minutos = Math.floor(segundos / 60);
            const seg = segundos % 60;
            const tempo = `${String(minutos).padStart(2, '0')}:${String(seg).padStart(2, '0')} min`;
            return tempo;
        }
    </script>

    <!-- Script de Validação Bootstrap -->
    <?php $this->load->view('templates/validator_form'); ?>
</section>