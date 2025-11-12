<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $id ?>_label">Excluir Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <form id="form_usuario_edicao" method="POST" action="<?= site_url("Usuarios/excluir_usuarios") ?>">
                    <input type="hidden" id="usuario_id" name="usuario_id_excluir">

                    <div class="mb-3">
                        <h5><b>Tem certeza que deseja excluir o usuário com os seguintes dados:</b></h5>
                        <label for="usuario_nome" class="form-label">Nome do Usuário</label>
                        <input type="text" id="usuario_nome" name="usuario_nome_excluir" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="usuario_matricula" class="form-label">Matrícula</label>
                        <input type="text" id="usuario_matricula" name="usuario_matricula_excluir" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="usuario_data_nasc" class="form-label">Data de Nascimento</label>
                        <input type="date" id="usuario_data_nasc" name="usuario_data_nascimento_excluir"
                            class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="usuario_sexo" class="form-label">Sexo</label>
                        <input type="text" id="usuario_sexo" name="usuario_sexo_excluir" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-success">Sim</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('usuario_modal_excluir');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // botão que abriu o modal

                // Pega os valores dos atributos data-*
                const id = button.getAttribute('data-id');
                const nome = button.getAttribute('data-nome');
                const matricula = button.getAttribute('data-matricula');
                const dataNascimento = button.getAttribute('data-data-nascimento');
                const sexo = button.getAttribute('data-sexo');

                // Preenche os campos do modal
                modal.querySelector('#usuario_id').value = id;
                modal.querySelector('#usuario_nome').value = nome;
                modal.querySelector('#usuario_matricula').value = matricula;
                modal.querySelector('#usuario_data_nasc').value = dataNascimento;
                modal.querySelector('#usuario_sexo').value = sexo;
            });
        });
    </script>

</div>