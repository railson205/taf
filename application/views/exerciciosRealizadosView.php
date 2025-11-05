<section class="content">
    <div class="container-fluid">
        <?php
        foreach ($exercicios_realizados['registro_exercicios'] as $registro) {
            $qtdExercicios = count($registro['exercicios']);
        }
        $this->load->view('templates/small_box', [
            'color' => 'bg-info',
            'value' => $qtdExercicios,
            'title' => 'Exercícios realizados',
            'icon' => 'fa-solid fa-person-swimming'
        ]);
        $usuarios_options = array_para_select($usuarios, 'id', 'nome');
        $exercicios_options = array_para_select($tipos_exercicios, 'exercicio_id', 'nome_exercicio');
        $notas_options = array_para_select($notas, 'id', 'indice');
        $ex_unic = $exercicios_realizados['exercicios_unicos_usuarios'];
        ?>

        <h3>Adicionar Exercícios</h3>

        <div class="col-md-6">
            <!--Form-->
            <form method="POST" action="<?= site_url("ExerciciosRealizados/adicionar_exercicio_realizado") ?>"
                class="needs-validation" novalidate>


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
                    'options' => $notas_options,
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
                                    <th rowspan="2" class="text-center border-end border-top border-dark">Grupo da Faixa
                                        Etária</th>
                                    <?php foreach ($ex_unic as $exercicio): ?>
                                        <th colspan="2" class="text-center border-end border-dark bg-secondary text-white">
                                            <?= htmlspecialchars($exercicio) ?>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>

                                    <?php foreach ($ex_unic as $exercicio): ?>
                                        <th class="text-center border-end border-dark">Modo de Contagem</th>
                                        <th class="text-center border-end border-dark">Índice</th>
                                    <?php endforeach; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($exercicios_realizados)):
                                    foreach ($exercicios_realizados['registro_exercicios'] as $key => $er):
                                        debug($er);
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td class="text-center"><?= $er['nome'] ?? '-' ?></td>
                                            <td class="text-center"><?= $er['sexo'] ?? '-' ?></td>
                                            <td class="text-center"><?= $er['faixa_etaria'] ?? '-' ?></td>
                                            <td class="text-center"><?= $er['grupo_faixa'] ?? '-' ?></td>

                                            <?php
                                            // Mapeia os exercícios do usuário para facilitar acesso pelo nome
                                            $map_exercicios = [];
                                            foreach ($er['exercicios'] as $ex) {
                                                $map_exercicios[$ex['nome_exercicio']] = $ex;
                                            }

                                            foreach ($ex_unic as $exercicio):
                                                $ex = $map_exercicios[$exercicio] ?? null;
                                                ?>
                                                <td class="text-center"><?= $ex['modo_contagem'] ?? '-' ?></td>
                                                <td class="text-center">
                                                    <?= $ex['modo_contagem'] == 'Tempo' ? segundos_para_tempo($ex['indice']) : $ex['indice'] ?? '-' ?>
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
                const infoExercicio = exercicios.find(e => e.exercicio_id === String(exercicioSelecionado));



                const notasSelecionadas = notas.filter(n => {
                    const idade_usuario = new Date().getFullYear() - new Date(infoUsuario.data_nascimento).getFullYear();
                    const usuarioNaFaixa = faixa.find(f => f.id == n.faixa_id && parseInt(f.idade_inicial) <= idade_usuario && idade_usuario <= parseInt(f.idade_final));

                    return infoUsuario.sexo == n.sexo &&
                        infoExercicio.exercicio_id == n.exercicio_id &&
                        usuarioNaFaixa
                }
                );
                console.log(notasSelecionadas);

                const campoNota = document.getElementById('nota_id');
                // Limpa o select antes de adicionar novas opções
                campoNota.innerHTML = '';

                // Se não encontrou notas, desabilita e mostra uma opção vazia
                if (!notasSelecionadas.length) {
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

                notasSelecionadas.forEach(nota => {
                    const opt = document.createElement('option');

                    opt.textContent = `${nota.modo_contagem == 'Tempo' ? seg_para_tempo(nota.indice) : nota.indice + ' repetições' ?? ''}`;
                    opt.value = nota.id;

                    campoNota.appendChild(opt);
                });
            }
        }

        function seg_para_tempo(segundos) {
            const tempo = `${Math.floor(segundos / 60)}:${segundos % 60} min`;
            return tempo;
        }
    </script>

    <!-- Script de Validação Bootstrap -->
    <?php $this->load->view('templates/validator_form'); ?>
</section>