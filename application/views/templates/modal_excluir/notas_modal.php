<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $id ?>_label">Excluir Notas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <form id="form_notas_excluir" method="POST" action="<?= site_url("Notas/excluir_nota") ?>">
                    <input type="hidden" id="notas_id" name="notas_id_excluir">

                    <div class="mb-3">
                        <h5><b>Tem certeza que deseja excluir a nota com os seguintes dados:</b></h5>
                        <label for="notas_faixa" class="form-label">Faixa Etária</label>
                        <input id="notas_faixa" name="notas_faixa_excluir" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="notas_sexo" class="form-label">Sexo</label>
                        <input id="notas_sexo" name="notas_sexo_excluir" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="notas_valor_nota" class="form-label">Nota</label>
                        <input id="notas_valor_nota" name="notas_valor_nota_excluir" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="notas_exercicio" class="form-label">Exercícios</label>
                        <input id="notas_exercicio" name="notas_exercicio_excluir" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="notas_indice" class="form-label">Índice</label>
                        <input id="notas_indice" name="notas_indice_excluir" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-success">Sim</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('notas_modal_excluir');
            if (!modal) return;

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                // ---- CAPTURA DOS DADOS JSON ----
                const selecionado = parseJSON(button.getAttribute('data-selecionado')) || {};
                const opcoes = parseJSON(button.getAttribute('data-opcoes')) || {};

                // ---- PREENCHER CAMPOS DO MODAL ----
                preencherInput('notas_id',selecionado.id);
                preencherInput('notas_faixa', selecionado.faixa_id, opcoes.faixas);
                preencherInput('notas_sexo', selecionado.sexo, opcoes.sexos);
                preencherInput('notas_valor_nota', selecionado.valor_nota, opcoes.notas);
                preencherInput('notas_exercicio', selecionado.exercicio_id, opcoes.exercicios);

                // Descobre o modo do exercício já selecionado (se houver)
                let modoSelecionado = null;
                if (selecionado.exercicio_id && Array.isArray(opcoes.modo_contagem)) {
                    opcoes.modo_contagem.forEach(item => {
                        if (typeof item === 'object' && item !== null) {
                            const key = Object.keys(item)[0];
                            if (key == selecionado.exercicio_id) modoSelecionado = item[key];
                        }
                    });
                }
                modal.querySelector('#notas_indice').value = modoSelecionado == 'Tempo' ? segundosParaMMSS(selecionado.indice) : selecionado.indice;


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
                                if(valorSelecionado==key){
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

            // ---- FUNÇÃO SEGURA PARA JSON ----
            function parseJSON(str) {
                try {
                    return JSON.parse(str);
                } catch {
                    console.warn('Falha ao parsear JSON:', str);
                    return null;
                }
            };
            // ---- CONVERTE SEGUNDOS PARA mm:ss (com padding) ----
            function segundosParaMMSS(totalSegundos) {
                if (totalSegundos === null || totalSegundos === undefined || Number.isNaN(totalSegundos)) return '';
                totalSegundos = Math.max(0, parseInt(totalSegundos, 10));
                const minutos = Math.floor(totalSegundos / 60);
                const segundos = totalSegundos % 60;
                return String(minutos).padStart(2, '0') + ':' + String(segundos).padStart(2, '0');
            };
        });
    </script>
</div>