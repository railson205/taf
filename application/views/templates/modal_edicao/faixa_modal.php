<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $id ?>_label">Editar Faixa Etária</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <form id="form_faixa_edicao" method="POST" action="<?= site_url("FaixasEtarias/editar_faixa") ?>">
                    <input type="hidden" id="faixa_id" name="faixa_id_edicao">

                    <div class="mb-3">
                        <label for="faixa_nome" class="form-label">Nome do Grupo</label>
                        <input type="text" id="faixa_nome" name="faixa_nome_edicao" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="faixa_idade_inicial" class="form-label">Idade Inicial</label>
                        <input type="number" id="faixa_idade_inicial" name="faixa_idade_inicial_edicao"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="faixa_idade_final" class="form-label">Idade Final</label>
                        <input type="number" id="faixa_idade_final" name="faixa_idade_final_edicao"
                            class="form-control">
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