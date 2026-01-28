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

                <form id="form_seguranca_excluir" method="POST" action="<?= site_url("Seguranca/excluir_login") ?>">
                    <input type="hidden" id="seguranca_id" name="seguranca_id_excluir">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Email</h6>
                                    <p id="seguranca_email" class="mb-0 fw-bold"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nível de Segurança</h6>
                                    <p id="seguranca_nivel" class="mb-0 fw-bold"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nome do Usuário</h6>
                                    <p id="seguranca_nome" class="mb-0 fw-bold"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Matrícula</h6>
                                    <p id="seguranca_matricula" class="mb-0 fw-bold"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Data de Nascimento</h6>
                                    <p id="seguranca_data_nasc" class="mb-0 fw-bold"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Sexo</h6>
                                    <p id="seguranca_sexo" class="mb-0 fw-bold"></p>
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
        const modal = document.getElementById('seguranca_modal_excluir');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const selecionado = parseJSON(button.getAttribute('data-selecionado')) || {};
            console.log(selecionado);

            modal.querySelector('#seguranca_id').value = selecionado.id;

            modal.querySelector('#seguranca_email').textContent = selecionado.email;
            modal.querySelector('#seguranca_nivel').textContent = selecionado.nivel;
            modal.querySelector('#seguranca_nome').textContent = selecionado.nome;
            modal.querySelector('#seguranca_matricula').textContent = selecionado.matricula;
            modal.querySelector('#seguranca_data_nasc').textContent = selecionado.data_de_nascimento;
            modal.querySelector('#seguranca_sexo').textContent = selecionado.sexo;
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
    });
</script>