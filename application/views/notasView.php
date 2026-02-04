<section class="content">
    <div class="container-fluid">
        <?php
        $this->load->view('templates/small_box', [
            'color' => 'marrom',
            'value' => count($notas),
            'title' => 'Notas dos Exercícios',
            'icon' => 'fa-solid fa-file-pen'
        ]);
        $faixa_options = array_para_select($faixa, 'id', 'faixa_etaria');
        $exercicios_options = array_para_select($exercicios, 'id', 'nome_do_exercicio');
        $modo_options = array_para_select($exercicios, 'id', 'modo_de_contagem');
        $notas_options = array_map(function ($f) {
            return $f;
        }, range(0.5, 10, 0.5));
        $cores = geraCoresDegrade(min($notas_options), max($notas_options), count($notas_options) - 1, [255, 0, 0], [0, 255, 0], 0.6);
        $notas_por_sexo = [];
        foreach ($notas as $n) {
            $notas_por_sexo[$n['sexo']][] = $n;
        }
        ?>

        <?php $this->load->view('templates/modal_edicao/notas_modal', ['id' => 'notas_modal_editar']); ?>
        <?php $this->load->view('templates/modal_excluir/notas_modal', ['id' => 'notas_modal_excluir']); ?>

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

        <!--Form-->
        <div class="col-md-6">
            <h3>Adicionar Notas</h3>
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
            <div class="col-md-12">.
                <h5 class="mb-0">Notas</h5>
                <?php $this->load->view('templates/tabelas/tabela_de_indices', ['nome_tabela' => 'Masculino', 'infoNotas' => $notas_por_sexo, 'infoFaixa' => $faixa, 'infoExercicios' => $exercicios, 'cores' => $cores]) ?>
                <?php $this->load->view('templates/tabelas/tabela_de_indices', ['nome_tabela' => 'Feminino', 'infoNotas' => $notas_por_sexo, 'infoFaixa' => $faixa, 'infoExercicios' => $exercicios, 'cores' => $cores]) ?>
                <script>
                    //TODO: consertar tabela e mostrar botão de exportação
                    $(document).ready(function () {
                        if ($.fn.DataTable.isDataTable('.datatable')) return;

                        const titulo = $('.datatable').data('export-title') || 'Relatório';

                        $('.datatable').DataTable({
                            destroy: true,
                            ordering: false,
                            responsive: true,
                            pageLength: 20,
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf"></i> PDF',
                                    className: 'btn btn-danger',
                                    title: titulo,
                                    orientation: 'landscape',
                                    pageSize: 'A4',

                                    customize: function (doc) {

                                        /* ====== ESTILO GLOBAL ====== */
                                        doc.defaultStyle.fontSize = 9;
                                        doc.defaultStyle.alignment = 'center';

                                        /* ====== TÍTULO ====== */
                                        doc.styles.title = {
                                            fontSize: 16,
                                            bold: true,
                                            margin: [0, 0, 0, 12],
                                            alignment: 'center'
                                        };

                                        /* ====== CABEÇALHO DA TABELA ====== */
                                        doc.styles.tableHeader = {
                                            fillColor: '#6c757d',   // cinza Bootstrap
                                            color: '#ffffff',
                                            bold: true,
                                            fontSize: 10,
                                            alignment: 'center'
                                        };

                                        /* ====== AJUSTE DA TABELA ====== */
                                        const table = doc.content.find(c => c.table);
                                        table.layout = {
                                            hLineWidth: function () { return 0.5; },
                                            vLineWidth: function () { return 0.5; },
                                            hLineColor: function () { return '#cccccc'; },
                                            vLineColor: function () { return '#cccccc'; },
                                            paddingLeft: function () { return 6; },
                                            paddingRight: function () { return 6; },
                                            paddingTop: function () { return 4; },
                                            paddingBottom: function () { return 4; }
                                        };

                                        /* ====== ZEBRA STRIPING (igual table-striped) ====== */
                                        const body = table.table.body;

                                        for (let i = 1; i < body.length; i++) {
                                            if (i % 2 === 0) {
                                                body[i].forEach(cell => {
                                                    cell.fillColor = '#f8f9fa'; // cinza claro Bootstrap
                                                });
                                            }
                                        }

                                    }
                                }
                            ]
                            ,
                            language: {
                                url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json"
                            }

                        });
                    });

                </script>
            </div>

        </div>
        <!--Tabela -->
    </div>
    </div>

    <script>
        const tipos_exercicios = <?= json_encode($exercicios) ?>;


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
            const exercicio = tipos_exercicios.find(e => e.id === String(campo_id.value));
            if (!exercicio) {
                campo_contagem.disabled = true;
                return;
            }

            const modo_de_contagem = exercicio.modo_de_contagem;
            console.log(exercicio);
            console.log(modo_de_contagem);

            campo_contagem.removeEventListener('input', aplicarMascaraTempo);

            if (modo_de_contagem === 'Tempo') {
                campo_contagem.type = 'text';
                campo_contagem.placeholder = 'mm:ss';
                campo_contagem.disabled = false;
                campo_contagem.addEventListener('input', aplicarMascaraTempo);
            }
            else if (modo_de_contagem === 'Contagem') {
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