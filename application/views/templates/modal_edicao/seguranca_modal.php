<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <!-- Header-->
            <div class="modal-header text-white modal-edicao">
                <h5 class="modal-title d-flex align-items-center gap-2">Editar Login</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <!-- Header-->

            <!-- Body-->
            <div class="modal-body bg-light">
                <form id="form_exercicio_edicao" method="POST" action="<?= site_url("Seguranca/editar_login") ?>">
                    <input type="hidden" id="seguranca_id" name="seguranca_id_editar">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nome</h6>
                                    <p id="seguranca_nome" class="mb-0 fw-bold"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nível</h6>
                                    <select id="seguranca_nivel" name="seguranca_nivel_editar"
                                        class="form-select"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Email</h6>
                                    <input type="text" id="seguranca_email" name="seguranca_email_editar"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>



                    <button type="submit" class="btn btn-success mt-3">Salvar</button>
                </form>
            </div>
            <!-- Body-->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('seguranca_modal_editar');
            if (!modal) return;

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                // ---- CAPTURA DOS DADOS JSON ----
                const selecionado = parseJSON(button.getAttribute('data-selecionado')) || {};
                const nivelOptions = button.getAttribute('data-nivel-options').split(',') || [];


                // ---- PREENCHER CAMPOS DO MODAL ----

                preencherInput('seguranca_id', selecionado.id);
                preencherInput('seguranca_usuario_id', selecionado.usuario_id);

                modal.querySelector('#seguranca_nome').textContent = selecionado.nome;
                preencherInput('seguranca_email', selecionado.email);

                const campoNivel = document.getElementById('seguranca_nivel');
                campoNivel.innerHTML = '';

                nivelOptions.forEach(nivel => {
                    const opt = document.createElement('option');

                    opt.textContent = nivel;
                    opt.value = nivel;
                    campoNivel.appendChild(opt);
                });
                modal.querySelector('#seguranca_nivel').value = selecionado.nivel;
            });

            /**
            * Preenche um <input> considerando tanto arrays quanto dicionários
            */
            function preencherInput(id, valorSelecionado, opcoes = []) {
                const input = document.getElementById(id);
                if (!input || !opcoes) return;

                input.innerHTML = '';

                if (opcoes.length == 0) {
                    modal.querySelector('#' + id).value = valorSelecionado;
                } else {

                    opcoes.forEach(item => {
                        if (typeof item === 'object' && item !== null) {
                            Object.entries(item).forEach(([key, value]) => {
                                if (valorSelecionado == key) {
                                    modal.querySelector('#' + id).value = value;
                                }
                            });
                        } else {
                            if (item == valorSelecionado) {
                                modal.querySelector('#' + id).value = item;
                            }
                        }
                    });
                }
            };

            // ---- CONVERTE SEGUNDOS PARA mm:ss (com padding) ----
            function segundosParaMMSS(totalSegundos) {
                if (totalSegundos === null || totalSegundos === undefined || Number.isNaN(totalSegundos)) return '';
                totalSegundos = Math.max(0, parseInt(totalSegundos, 10));
                const minutos = Math.floor(totalSegundos / 60);
                const segundos = totalSegundos % 60;
                return String(minutos).padStart(2, '0') + ':' + String(segundos).padStart(2, '0');
            }

            // ---- FUNÇÃO SEGURA PARA JSON ----
            function parseJSON(str) {
                try {
                    return JSON.parse(str);
                } catch {
                    console.warn('Falha ao parsear JSON:', str);
                    return null;
                }
            }
        });
    </script>

</div>