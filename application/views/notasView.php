<section class="content">
    <div class="container-fluid">
        <div class="row">
            <?php
            $this->load->view('templates/small_box', [
                'color' => 'bg-danger',
                'value' => count($notas),
                'title' => 'Notas dos Exercícios',
                'icon' => 'fa-solid fa-file-pen'
            ]);
            $faixa_options = array_para_select($faixa, 'id', 'faixa_etaria');
            $exercicios_options = array_para_select($exercicios, 'exercicio_id', 'nome_exercicio');
            $notas_options = array_map(function ($f) {
                return $f;
            }, range(0.5, 10, 0.5));
            ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Abrir Tabela
            </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tabela</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <?php $this->load->view('templates/tabelas/tabela_de_indices',['notas'=>$notas,'faixa'=>$faixa,'exercicios'=>$exercicios])?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3>Adicionar Notas</h3>

        <!--Form-->
        <div class="col-md-6">
            <form method="POST" action="<?= site_url("Notas/adicionar_nota") ?>" class="needs-validation" novalidate>
                <!-- Faixa Etária-->
                <?php $this->load->view('templates/inputs/input_select', ['id' => 'faixa_id_nota', 'title' => 'Faixa Etária', 'placeholder' => 'Escolha uma faixa etária', 'options' => $faixa_options]) ?>
                <!-- Sexo-->
                <?php
                $this->load->view('templates/inputs/input_select', [
                    'id' => 'sexo_nota',
                    'title' => 'Sexo',
                    'placeholder' => 'Selecione um sexo',
                    'options' => ['Masculino', 'Feminino'],
                ]);
                ?>
                <!-- Notas-->
                <?php $this->load->view('templates/inputs/input_select', ['id' => 'valor_nota', 'title' => 'Nota', 'placeholder' => 'Escolha uma nota', 'options' => $notas_options]) ?>
                <!-- Exercícios-->
                <?php $this->load->view('templates/inputs/input_select', ['id' => 'exercicio_id_nota', 'title' => 'Exercícios', 'placeholder' => 'Escolha um exercício', 'options' => $exercicios_options]) ?>
                <!--Indice/Meta-->
                <?php
                $this->load->view('templates/inputs/input_texto', [
                    'id' => 'indice_nota',
                    'title' => 'Índice',
                    'placeholder' => 'Indique um índice',
                    'type' => 'number',
                    'disabled' => true,
                ]);
                ?>

                <button type="submit" class="btn btn-primary me-1">Nova Nota</button>
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
                                    <th>Faixa Etária</th>
                                    <th>Grupo da Faixa Etária</th>
                                    <th>Sexo</th>
                                    <th>Nota</th>
                                    <th>Nome do Exercício</th>
                                    <th>Modo de Contagem do Exercício</th>
                                    <th>Índice do Exercício</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($notas)):
                                    foreach ($notas as $key => $n):
                                        ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $n['faixa_etaria'] ?? '-' ?></td>
                                            <td><?= $n['grupo_faixa_etaria'] ?? '-' ?></td>
                                            <td><?= $n['sexo'] ?? '-' ?></td>
                                            <td><?= $n['valor_nota'] ?? '-' ?></td>
                                            <td><?= $n['nome_exercicio'] ?? '-' ?></td>
                                            <td><?= $n['modo_contagem'] ?? '-' ?></td>
                                            <td><?= $n['modo_contagem'] == 'Tempo' ? segundos_para_tempo($n['indice']) : $n['indice'] ?? '-' ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">Nenhuma nota encontrada.</td>
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
        const tipos_exercicios = <?= json_encode($exercicios) ?>;
        const notas_exercicios = <?= json_encode($notas) ?>;


        document.addEventListener('DOMContentLoaded', function () {
            const campo_id = document.getElementById('exercicio_id_nota');

            if (campo_id) {
                campo_id.addEventListener('change', onChangeExerciciosNota);
            }
        });

        function onChangeExerciciosNota() {
            const campo_id = document.getElementById('exercicio_id_nota');
            const campo_contagem = document.getElementById('indice_nota');

            //Procura no array qual objeto com a key id tem o mesmo valor de campo.value
            const exercicio = tipos_exercicios.find(e => e.exercicio_id === String(campo_id.value));
            if (!exercicio) {
                campo_contagem.disabled = true;
                return;
            }

            const modo_contagem = exercicio.modo_contagem;
            console.log(exercicio);
            console.log(modo_contagem);

            campo_contagem.removeEventListener('input', aplicarMascaraTempo);

            if (modo_contagem === 'Tempo') {
                campo_contagem.type = 'text';
                campo_contagem.placeholder = 'mm:ss';
                campo_contagem.disabled = false;
                campo_contagem.addEventListener('input', aplicarMascaraTempo);
            }
            else if (modo_contagem === 'Contagem') {
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

        // Função que simula o "extra" de máscara de tempo
        function aplicarMascaraTempo(event) {
            //Permite somente números
            let v = event.target.value.replace(/\D/g, '');
            //Limita para 4 dígitos
            if (v.length > 4) v = v.slice(0, 4);
            //Adiciona : se tiver mais de 2 dígitos
            if (v.length >= 3) v = v.slice(0, 2) + ':' + v.slice(2);
            let parts = v.split(':');
            //Permite que os segundos vão até 59
            if (parts[1]?.length == 1 && parseInt(parts[1]) > 5) parts[1] = '';
            event.target.value = parts.join(':');
        }
    </script>

    <!-- Script de Validação Bootstrap -->
    <?php $this->load->view('templates/validator_form'); ?>
</section>