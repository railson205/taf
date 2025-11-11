<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $id ?>_label">Editar Exercícios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <form id="form_exercicio_edicao" method="POST"
                    action="<?= site_url("Exercicios/excluir_exercicios") ?>">
                    <input type="hidden" id="exercicio_id" name="exercicio_id_excluir">

                    <div class="mb-3">
                        <h5><b>Tem certeza que deseja excluir o exercício com os seguintes dados:</b></h5>
                        <label for="exercicio_nome" class="form-label">Nome do Exercício</label>
                        <input type="text" id="exercicio_nome" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="exercicio_sexo" class="form-label">Modo de Contagem</label>
                        <input class="form-control" id="exercicio_modo_contagem" readonly>
                        </input>
                    </div>

                    <button type="submit" class="btn btn-success">Sim</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('tipo_exercicio_modal_excluir');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // botão que abriu o modal

                // Pega os valores dos atributos data-*
                const id = button.getAttribute('data-id');
                const nome = button.getAttribute('data-nome-exercicio');
                const modoContagemSelecionado = button.getAttribute('data-modo-contagem-selecionado');

                // Preenche os campos do modal
                modal.querySelector('#exercicio_id').value = id;
                modal.querySelector('#exercicio_nome').value = nome;
                modal.querySelector('#exercicio_modo_contagem').value = modoContagemSelecionado;
            });
        });
    </script>

</div>