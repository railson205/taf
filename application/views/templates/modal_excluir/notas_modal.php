<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i> Excluir Nota
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">

                <div class="alert alert-warning d-flex align-items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                    <div>
                        <strong>Atenção!</strong><br>
                        A nota será excluída permanentemente.  
                        Essa ação não pode ser desfeita.
                    </div>
                </div>

                <form id="form_notas_excluir" method="POST" action="<?= site_url("Notas/excluir_nota") ?>">
                    <input type="hidden" id="notas_id" name="notas_id_excluir">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Faixa Etária</h6>
                                    <p id="notas_faixa" class="fw-bold mb-0"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Sexo</h6>
                                    <p id="notas_sexo" class="fw-bold mb-0"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nota</h6>
                                    <p id="notas_valor_nota" class="fw-bold mb-0"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Exercício</h6>
                                    <p id="notas_exercicio" class="fw-bold mb-0"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Índice</h6>
                                    <p id="notas_indice" class="fw-bold mb-0"></p>
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
