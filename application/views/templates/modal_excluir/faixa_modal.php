<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i> Excluir Faixa Etária
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">

                <div class="alert alert-warning d-flex align-items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                    <div>
                        <strong>Confirmação necessária</strong><br>
                        Esta faixa será excluída permanentemente.
                    </div>
                </div>

                <form id="form_faixa_excluir" method="POST" action="<?= site_url("FaixasEtarias/excluir_faixa") ?>">
                    <input type="hidden" id="faixa_id" name="faixa_id_excluir">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nome do Grupo</h6>
                                    <p id="faixa_nome" class="fw-bold mb-0"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Idade Inicial</h6>
                                    <p id="faixa_idade_inicial" class="fw-bold mb-0"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Idade Final</h6>
                                    <p id="faixa_idade_final" class="fw-bold mb-0"></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-danger btn-lg px-4">
                            <i class="fa-solid fa-trash"></i> Excluir Faixa
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('faixa_modal_excluir');
            if (!modal) return;

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                // lê atributos data-* do botão que abriu o modal
                const id = button.getAttribute('data-id') ?? '';
                const nome = button.getAttribute('data-nome') ?? '';
                const idadeInicial = button.getAttribute('data-idade-inicial') ?? '';
                const idadeFinal = button.getAttribute('data-idade-final') ?? '';

                // preenche o input hidden com o id (mantém envio do form)
                const hiddenId = modal.querySelector('#faixa_id');
                if (hiddenId) hiddenId.value = id;

                // preenche os <p> que mostram os valores (não editáveis)
                const elNome = modal.querySelector('#faixa_nome');
                const elIni = modal.querySelector('#faixa_idade_inicial');
                const elFim = modal.querySelector('#faixa_idade_final');

                if (elNome) elNome.textContent = nome;
                if (elIni) elIni.textContent = idadeInicial;
                if (elFim) elFim.textContent = idadeFinal;
            });
        });
    </script>


</div>