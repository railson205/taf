<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" >
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <!-- Header-->
            <div class="modal-header text-white modal-edicao">
                <h5 class="modal-title d-flex align-items-center gap-2">Editar Login</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <!-- Header-->

            <div class="modal-body bg-light">
                <form id="form_faixa_edicao" method="POST" action="<?= site_url("FaixasEtarias/editar_faixa") ?>">
                    <input type="hidden" id="faixa_id" name="faixa_id_edicao">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nome do Grupo</h6>
                                    <input type="text" id="faixa_nome" name="faixa_nome_edicao" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Idade Inicial</h6>
                                    <input type="number" id="faixa_idade_inicial" name="faixa_idade_inicial_edicao"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Idade Final</h6>
                                    <input type="number" id="faixa_idade_final" name="faixa_idade_final_edicao"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('faixa_modal_editar');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // botão que abriu o modal

                // Pega os valores dos atributos data-*
                const id = button.getAttribute('data-id');
                const nome = button.getAttribute('data-nome');
                const idadeInicial = button.getAttribute('data-idade-inicial');
                const idadeFinal = button.getAttribute('data-idade-final');

                // Preenche os campos do modal
                modal.querySelector('#faixa_id').value = id;
                modal.querySelector('#faixa_nome').value = nome;
                modal.querySelector('#faixa_idade_inicial').value = idadeInicial;
                modal.querySelector('#faixa_idade_final').value = idadeFinal;
            });
        });
    </script>

</div>