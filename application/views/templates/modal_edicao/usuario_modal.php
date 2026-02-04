<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <!-- Header-->
            <div class="modal-header text-white modal-edicao">
                <h5 class="modal-title d-flex align-items-center gap-2">Editar Usuário</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <!-- Header-->

            <div class="modal-body">
                <form id="form_usuario_edicao" method="POST" action="<?= site_url("Usuarios/editar_usuarios") ?>">
                    <input type="hidden" id="usuario_id" name="usuario_id_editar">


                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Nome do Usuário</h6>
                                    <input type="text" id="usuario_nome" name="usuario_nome_editar"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Matrícula</h6>
                                    <input type="text" id="usuario_matricula" name="usuario_matricula_editar"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Data de Nascimento</h6>
                                    <input type="date" id="usuario_data_nasc" name="usuario_data_de_nascimento_editar"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-1">Sexo</h6>
                                    <select class="form-select" id="usuario_sexo" name="usuario_sexo_editar">
                                    </select>
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
            const modal = document.getElementById('usuario_modal_editar');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // botão que abriu o modal

                // Pega os valores dos atributos data-*
                const id = button.getAttribute('data-id');
                const nome = button.getAttribute('data-nome');
                const matricula = button.getAttribute('data-matricula');
                const dataNascimento = button.getAttribute('data-data-nascimento');
                const sexoSelecionado = button.getAttribute('data-sexo-selecionado');
                const sexoOptions = button.getAttribute('data-sexo-options').split(',');

                // Preenche os campos do modal
                modal.querySelector('#usuario_id').value = id;
                modal.querySelector('#usuario_nome').value = nome;
                modal.querySelector('#usuario_matricula').value = matricula;
                modal.querySelector('#usuario_data_nasc').value = dataNascimento;

                //Pega o campo com select e limpa o conteúdo
                const campoSexo = document.getElementById('usuario_sexo');
                campoSexo.innerHTML = '';

                //Coloca as opções dentro do select
                sexoOptions.forEach(sexo => {
                    const opt = document.createElement('option');

                    opt.textContent = sexo;
                    opt.value = sexo;
                    campoSexo.appendChild(opt);
                });

                //Define o valor que deve estar selecionado no select
                modal.querySelector('#usuario_sexo').value = sexoSelecionado;
            });
        });
    </script>

</div>