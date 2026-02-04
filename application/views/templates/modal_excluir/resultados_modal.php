<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">

            <!-- HEADER -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i> Excluir Resultado
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body bg-light">

                <div class="alert alert-warning d-flex align-items-center gap-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                    <div>
                        <strong>Atenção!</strong><br>
                        Você está prestes a excluir este resultado permanentemente.
                        Essa ação não pode ser desfeita.
                    </div>
                </div>

                <form id="form_resultados_excluir" method="POST"
                    action="<?= site_url("Resultados/excluir_resultados") ?>">

                    <input type="hidden" id="resultados_id" name="resultados_id_excluir">
                    <input type="hidden" id="resultados_usuario_id" name="resultados_usuario_id_excluir">
                    <input type="hidden" id="resultados_exercicio_id" name="resultados_exercicio_id_excluir">

                    <!-- CARDS DE RESUMO -->
                    <div class="row g-3">

                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nome</h6>
                                    <input id="resultados_nome" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Sexo</h6>
                                    <input id="resultados_sexo" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Faixa Etária</h6>
                                    <input id="resultados_faixa" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Grupo Faixa</h6>
                                    <input id="resultados_grupo_faixa" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Exercício</h6>
                                    <input id="resultados_exercicio" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Índice</h6>
                                    <input id="resultados_indice" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-danger btn-lg px-4">
                            <i class="fa-solid fa-trash"></i> Confirmar Exclusão
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('resultados_modal_excluir');
        if (!modal) return;

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;

            // ---- CAPTURA DOS DADOS JSON ----
            const selecionado = parseJSON(button.getAttribute('data-selecionado')) || {};
            const opcoes = parseJSON(button.getAttribute('data-opcoes')) || {};



            // ---- PREENCHER CAMPOS DO MODAL ----
            preencherInput('resultados_id', selecionado.id);
            preencherInput('resultados_usuario_id', selecionado.usuario_id);
            preencherInput('resultados_exercicio_id', selecionado.exercicio_id);

            preencherInput('resultados_nome', selecionado.nome);
            preencherInput('resultados_sexo', selecionado.sexo);
            preencherInput('resultados_faixa', selecionado.faixa);
            preencherInput('resultados_grupo_faixa', selecionado.grupo_faixa);
            preencherInput('resultados_exercicio', selecionado.exercicio_id, opcoes.exercicios);

            const modoContagem = opcoes.all_exercicios.find(e => e.id == selecionado.exercicio_id)['modo_de_contagem'];
            preencherInput('resultados_indice', modoContagem == "Tempo" ? segundosParaMMSS(selecionado.indice) + ' min' : selecionado.indice);
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