<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $id ?>_label">Editar Exercícios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <form id="form_exercicio_edicao" method="POST" action="<?= site_url("Exercicios/editar_exercicios") ?>">
                    <input type="hidden" id="exercicio_id" name="exercicio_id_editar">

                    <div class="mb-3">
                        <label for="exercicio_nome" class="form-label">Nome do Exercício</label>
                        <input type="text" id="exercicio_nome" name="exercicio_nome_editar" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="exercicio_sexo" class="form-label">Modo de Contagem</label>
                        <select class="form-select" id="exercicio_modo_contagem" name="exercicio_modo_contagem_editar">
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Salvar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('tipo_exercicio_modal_editar');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // botão que abriu o modal

                // Pega os valores dos atributos data-*
                const id = button.getAttribute('data-id');
                const nome = button.getAttribute('data-nome-exercicio');
                const modoContagemSelecionado = button.getAttribute('data-modo-contagem-selecionado');
                const modoContagemOptions = button.getAttribute('data-modo-contagem-options').split(',');

                // Preenche os campos do modal
                modal.querySelector('#exercicio_id').value = id;
                modal.querySelector('#exercicio_nome').value = nome;

                //Pega o campo com select e limpa o conteúdo
                const campoModoContagem = document.getElementById('exercicio_modo_contagem');
                campoModoContagem.innerHTML = '';

                //Coloca as opções dentro do select
                modoContagemOptions.forEach(contagem => {
                    const opt = document.createElement('option');

                    opt.textContent = contagem;
                    opt.value = contagem;
                    campoModoContagem.appendChild(opt);
                });

                //Define o valor que deve estar selecionado no select
                modal.querySelector('#exercicio_modo_contagem').value = modoContagemSelecionado;
            });
        });
    </script>

</div>