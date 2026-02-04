<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content shadow-lg border-0">

            <!-- HEADER -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title d-flex align-items-center gap-2" id="<?= $id ?>_label">
                    <i class="fa-solid fa-triangle-exclamation fa-lg"></i>
                    Excluir Exercício
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body bg-light">

                <!-- AVISO -->
                <div class="alert alert-warning d-flex align-items-center gap-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                    <div>
                        <strong>Atenção!</strong><br>
                        Você está prestes a excluir este exercício permanentemente.<br>
                        <span class="text-danger">Essa ação não pode ser desfeita.</span>
                    </div>
                </div>

                <form id="form_exercicio_edicao" method="POST"
                    action="<?= site_url("Exercicios/excluir_exercicios") ?>">

                    <input type="hidden" id="exercicio_id" name="exercicio_id_excluir">

                    <!-- CARDS DE INFORMAÇÕES -->
                    <div class="row g-4">

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nome do Exercício</h6>
                                    <p id="exercicio_nome" class="fw-bold fs-6 mb-0"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Modo de Contagem</h6>
                                    <p id="exercicio_modo_de_contagem" class="fw-bold fs-6 mb-0"></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- BOTÕES -->
                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit" class="btn btn-danger px-4">
                            <i class="fa-solid fa-trash"></i> Excluir
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('tipo_exercicio_modal_excluir');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome-exercicio');
            const modoContagemSelecionado = button.getAttribute('data-modo-contagem-selecionado');

            modal.querySelector('#exercicio_id').value = id;
            modal.querySelector('#exercicio_nome').innerText = nome;
            modal.querySelector('#exercicio_modo_de_contagem').innerText = modoContagemSelecionado;
        });
    });
</script>


</div>