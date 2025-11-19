<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">

            <!-- HEADER -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i> Excluir Usuário
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body bg-light">

                <div class="alert alert-warning d-flex align-items-center gap-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                    <div>
                        <strong>Atenção!</strong><br>
                        Você está prestes a excluir este usuário permanentemente.<br>
                        Essa ação não pode ser desfeita.
                    </div>
                </div>

                <form id="form_usuario_excluir" method="POST" action="<?= site_url("Usuarios/excluir_usuarios") ?>">
                    <input type="hidden" id="usuario_id" name="usuario_id_excluir">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nome do Usuário</h6>
                                    <p id="usuario_nome" class="mb-0 fw-bold"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Matrícula</h6>
                                    <p id="usuario_matricula" class="mb-0 fw-bold"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Data de Nascimento</h6>
                                    <p id="usuario_data_nasc" class="mb-0 fw-bold"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Sexo</h6>
                                    <p id="usuario_sexo" class="mb-0 fw-bold"></p>
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
    const modal = document.getElementById('usuario_modal_excluir');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        modal.querySelector('#usuario_id').value = button.getAttribute('data-id');
        modal.querySelector('#usuario_nome').textContent = button.getAttribute('data-nome');
        modal.querySelector('#usuario_matricula').textContent = button.getAttribute('data-matricula');
        modal.querySelector('#usuario_data_nasc').textContent = button.getAttribute('data-data-nascimento');
        modal.querySelector('#usuario_sexo').textContent = button.getAttribute('data-sexo');
    });
});
</script>
