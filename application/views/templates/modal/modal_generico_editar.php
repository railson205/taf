<?php $nomeView = normalizarString($nome_modal); ?>

<div class="modal fade modal-edicao-generica" id="<?= $nomeView ?>_modal_editar" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-header modal-edicao text-white">
                <h5 class="modal-title">Editar <?= $nome_modal ?></h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">
                <form method="POST" action="<?= site_url($endpoint) ?>">

                    <!-- id vem do JSON -->
                    <input type="hidden" name="<?= $nomeView ?>_id_editar" data-field="id"
                        id="<?= $nomeView ?>_id_editar">

                    <div class="row g-3">
                        <?php foreach ($campos as $c): ?>
                            <?php [$nomeInput, $tipoInput] = explode('|', $c); ?>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-1">
                                            <?= $nomeInput ?>
                                        </h6>
                                        <!-- Define se vai ser select ou input-->
                                        <?php $nomeInput = normalizarString($nomeInput);
                                        switch ($tipoInput) {

                                            case 'select': ?>
                                                <select id="<?= $nomeView ?>_<?= $nomeInput ?>"
                                                    name="<?= $nomeView ?>_<?= $nomeInput ?>_editar" class="form-select">
                                                </select>
                                                <?php
                                                break;

                                            case 'read': ?>
                                                <input type="text" id="<?= $nomeView ?>_<?= $nomeInput ?>" class="form-control"
                                                    readonly>
                                                <?php
                                                break;

                                            default: ?>
                                                <input type="<?= $tipoInput ?? 'text' ?>" id="<?= $nomeView ?>_<?= $nomeInput ?>"
                                                    name="<?= $nomeView ?>_<?= $nomeInput ?>_editar" class="form-control">
                                                <?php
                                                break;
                                        }
                                        ?>


                                        <p id="<?= $nomeView ?>_<?= normalizarString($c) ?>" class="mb-0 fw-bold"></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">
                        Salvar
                    </button>
                </form>
            </div>

        </div>
    </div>
    <script>
        (function () {
            const nomes_e_tipos = <?= json_encode($campos) ?>;
            const nomeView = "<?= $nomeView ?>";

            document.querySelectorAll('.modal-edicao-generica').forEach(modal => {

                modal.addEventListener('show.bs.modal', function (event) {

                    const button = event.relatedTarget;
                    if (!button) return;

                    // ---- CAPTURA DOS DADOS JSON ----
                    const selecionado = parseJSON(button.getAttribute('data-selecionado')) || {};
                    const opcoes = parseJSON(button.getAttribute('data-opcoes')) || {};

                    modal.querySelector('#' + nomeView + '_id_editar').value = selecionado.id;

                    nomes_e_tipos.forEach(e => {
                        const [nome, tipo] = e.split('|');
                        const nomeInput = normalizarString(nome);

                        if (tipo === 'select') {
                            const campoSelect = modal.querySelector('#' + nomeView + '_' + nomeInput);
                            if (!campoSelect) return;

                            campoSelect.innerHTML = '';

                            (opcoes[nome] || []).forEach(item => {

                                const [valor, conteudo] = item.split("|");
                                const option = document.createElement('option');

                                option.value = valor;
                                option.textContent = conteudo ?? valor;

                                console.log(selecionado[nomeInput], item, valor);
                                if (selecionado[nomeInput] === conteudo) {
                                    option.selected = true;
                                }
                                campoSelect.appendChild(option);
                            });

                        } else {
                            const id_campo = '#' + nomeView + '_' + nomeInput;
                            const campo = modal.querySelector(id_campo);
                            if (!campo) return;
                            campo.value = selecionado[nomeInput] ?? '';
                        }
                    });

                });

            });


            // ---- FUNÇÃO SEGURA PARA JSON ----
            function parseJSON(str) {
                try {
                    return JSON.parse(str);
                } catch {
                    console.warn('Falha ao parsear JSON:', str);
                    return null;
                }
            }

            //Função para normalizar string
            function normalizarString(str) {
                if (!str) return '';

                return str
                    .toString()
                    .normalize('NFD')                 // separa acentos
                    .replace(/[\u0300-\u036f]/g, '')  // remove acentos
                    .replace(/[^a-zA-Z0-9\s]/g, '')   // remove caracteres especiais
                    .trim()
                    .toLowerCase()
                    .replace(/\s+/g, '_');            // espaços → _
            }
        })();



    </script>
</div>