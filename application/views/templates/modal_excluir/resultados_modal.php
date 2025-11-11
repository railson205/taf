<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $id ?>_label">Editar Notas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <form id="form_resultados_excluir" method="POST"
                    action="<?= site_url("Resultados/editar_resultados") ?>">
                    <input type="hidden" id="resultados_id" name="resultados_id_excluir">
                    <input type="hidden" id="resultados_usuario_id" name="resultados_usuario_id_excluir">
                    <input type="hidden" id="resultados_exercicio_id" name="resultados_exercicio_id_excluir">

                    <div class="mb-3">
                        <label for="resultados_nome" class="form-label">Nome</label>
                        <input id="resultados_nome" name="resultados_nome_excluir" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="resultados_sexo" class="form-label">Sexo</label>
                        <input id="resultados_sexo" name="resultados_sexo_excluir" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="resultados_faixa" class="form-label">Faixa Etária</label>
                        <input id="resultados_faixa" name="resultados_faixa_excluir" class="form-control" readonly>
                    </div>


                    <div class="mb-3">
                        <label for="resultados_grupo_faixa" class="form-label">Grupo da Faixa Etária</label>
                        <input id="resultados_grupo_faixa" name="resultados_grupo_faixa_excluir" class="form-control"
                            readonly>
                    </div>

                    <div class="mb-3">
                        <label for="resultados_exercicio" class="form-label">Exercício</label>
                        <input id="resultados_exercicio" name="resultados_exercicio_excluir" class="form-control"
                            readonly>
                    </div>

                    <div class="mb-3">
                        <label for="resultados_indice" class="form-label">Índice</label>
                        <input id="resultados_indice" name="resultados_indice_excluir" class="form-select" readonly>
                    </div>

                    <button type="submit" class="btn btn-success">Salvar</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('resultados_modal_excluir');
            if (!modal) return;

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                // ---- CAPTURA DOS DADOS JSON ----
                const selecionado = parseJSON(button.getAttribute('data-selecionado')) || {};
                const opcoes = parseJSON(button.getAttribute('data-opcoes')) || {};



                // ---- PREENCHER CAMPOS DO MODAL ----
                preencherInput('resultados_id', selecionado.id);
                preencherInput('resultados_usuario_id', selecionado.usuario_id);
                preencherInput('resultados_exercicio_id', selecionado.exercicio_id);

                preencherInput('resultados_nome', selecionado.nome);
                preencherInput('resultados_sexo', selecionado.sexo);
                preencherInput('resultados_faixa', selecionado.faixa);
                preencherInput('resultados_grupo_faixa', selecionado.grupo_faixa);
                preencherInput('resultados_exercicio', selecionado.exercicio_id, opcoes.exercicios);

                const modoContagem = opcoes.all_exercicios.find(e => e.id == selecionado.exercicio_id)['modo_contagem'];
                preencherInput('resultados_indice', modoContagem == "Tempo" ? segundosParaMMSS(selecionado.indice)+' min' : selecionado.indice);
            });

            /**
            * Preenche um <input> considerando tanto arrays quanto dicionários
            */
            function preencherInput(id, valorSelecionado, opcoes = []) {
                const input = document.getElementById(id);
                if (!input || !opcoes) return;

                input.innerHTML = '';

                if (opcoes.length == 0) {
                    modal.querySelector('#' + id).value = valorSelecionado;
                } else {

                    opcoes.forEach(item => {
                        if (typeof item === 'object' && item !== null) {
                            Object.entries(item).forEach(([key, value]) => {
                                if (valorSelecionado == key) {
                                    modal.querySelector('#' + id).value = value;
                                }
                            });
                        } else {
                            if (item == valorSelecionado) {
                                modal.querySelector('#' + id).value = item;
                            }
                        }
                    });
                }
            };

            // ---- CONVERTE SEGUNDOS PARA mm:ss (com padding) ----
            function segundosParaMMSS(totalSegundos) {
                if (totalSegundos === null || totalSegundos === undefined || Number.isNaN(totalSegundos)) return '';
                totalSegundos = Math.max(0, parseInt(totalSegundos, 10));
                const minutos = Math.floor(totalSegundos / 60);
                const segundos = totalSegundos % 60;
                return String(minutos).padStart(2, '0') + ':' + String(segundos).padStart(2, '0');
            }

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
</div>