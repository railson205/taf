<?php $nomeView = normalizarString($nome_modal); ?>

<div class="modal fade modal-excluir-generico" id="<?= $nomeView ?>_modal_excluir" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-header modal-excluir text-white">
                <h5 class="modal-title">Excluir <?= $nome_modal ?></h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">
                <div class="alert alert-warning d-flex align-items-center gap-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                    <div>
                        <strong>Atenção!</strong><br>
                        Você está prestes a excluir este registro permanentemente.<br>
                        Essa ação não pode ser desfeita.
                    </div>
                </div>
                <form method="POST" action="<?= site_url($endpoint) ?>">

                    <!-- id vem do JSON -->
                    <input type="hidden" name="<?= $nomeView ?>_id_excluir" data-field="id"
                        id="<?= $nomeView ?>_id_excluir">

                    <div class="row g-3">
                        <?php foreach ($campos as $c): ?>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-1">
                                            <?=$c?>
                                        </h6>
                                        <p id="<?= $nomeView ?>_<?= normalizarString($c) ?>" class="mb-0 fw-bold"></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="submit" class="btn btn-danger mt-3">
                        Confirmar Exclusão
                    </button>
                </form>
            </div>

        </div>
    </div>
    <script>
        (function () {
            const nomesCampos = <?= json_encode($campos) ?>;
            const nomeView = "<?= $nomeView ?>";

            document.querySelectorAll('.modal-excluir-generico').forEach(modal => {

                modal.addEventListener('show.bs.modal', function (event) {

                    const button = event.relatedTarget;
                    if (!button) return;

                    const selecionado = parseJSON(button.getAttribute('data-selecionado')) || {};

                    modal.querySelector('#' + nomeView + '_id_excluir').value = selecionado.id;
                    
                    nomesCampos.forEach(e => {
                        const nomeNormalizado=normalizarString(e);
                        if(nomeNormalizado=='data_de_nascimento'){
                            const [ano, mes, dia] = selecionado[nomeNormalizado].split('-');
                            selecionado[nomeNormalizado]=`${dia}/${mes}/${ano}`;
                        }
                        modal.querySelector('#' + nomeView + '_' + nomeNormalizado).textContent = selecionado[nomeNormalizado];
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