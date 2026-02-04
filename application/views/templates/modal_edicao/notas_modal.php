<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $id ?>_label">Editar Notas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <form id="form_notas_editar" method="POST" action="<?= site_url("Notas/editar_nota") ?>">
                    <input type="hidden" id="notas_id" name="notas_id_editar">

                    <div class="mb-3">
                        <label for="notas_faixa" class="form-label">Faixa Etária</label>
                        <select id="notas_faixa" name="notas_faixa_editar" class="form-select"></select>
                    </div>

                    <div class="mb-3">
                        <label for="notas_sexo" class="form-label">Sexo</label>
                        <select id="notas_sexo" name="notas_sexo_editar" class="form-select"></select>
                    </div>

                    <div class="mb-3">
                        <label for="notas_valor_nota" class="form-label">Nota</label>
                        <select id="notas_valor_nota" name="notas_valor_nota_editar" class="form-select"></select>
                    </div>

                    <div class="mb-3">
                        <label for="notas_exercicio" class="form-label">Exercícios</label>
                        <select id="notas_exercicio" name="notas_exercicio_editar" class="form-select"></select>
                    </div>

                    <div class="mb-3">
                        <label for="notas_indice" class="form-label">Índice</label>
                        <input id="notas_indice" name="notas_indice_editar" class="form-control" type="number">
                    </div>

                    <button type="submit" class="btn btn-success">Salvar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('notas_modal_editar');
            if (!modal) return;

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                // ---- CAPTURA DOS DADOS JSON ----
                const selecionado = parseJSON(button.getAttribute('data-selecionado')) || {};
                const opcoes = parseJSON(button.getAttribute('data-opcoes')) || {};

                // ---- PREENCHER CAMPOS DO MODAL ----
                preencherSelect('notas_faixa', selecionado.faixa_id, opcoes.faixas);
                preencherSelect('notas_sexo', selecionado.sexo, opcoes.sexos);
                preencherSelect('notas_valor_nota', selecionado.valor_nota, opcoes.notas);
                preencherSelect('notas_exercicio', selecionado.exercicio_id, opcoes.exercicios);

                const campoIndice = document.getElementById('notas_indice');
                const campoId = document.getElementById('notas_id');

                // Descobre o modo do exercício já selecionado (se houver)
                let modoSelecionado = null;
                if (selecionado.exercicio_id && Array.isArray(opcoes.modo_de_contagem)) {
                    opcoes.modo_de_contagem.forEach(item => {
                        if (typeof item === 'object' && item !== null) {
                            const key = Object.keys(item)[0];
                            if (key == selecionado.exercicio_id) modoSelecionado = item[key];
                        }
                    });
                }

                // Se for Tempo: converte segundos -> mm:ss e aplica máscara
                if (campoIndice) {
                    // limpa qualquer listener antigo
                    campoIndice.removeEventListener('input', aplicarMascaraTempo);

                    if (modoSelecionado === 'Tempo') {
                        campoIndice.type = 'text';
                        campoIndice.placeholder = 'mm:ss';
                        campoIndice.disabled = false;
                        campoIndice.value = selecionado.indice ? segundosParaMMSS(Number(selecionado.indice)) : '';
                        campoIndice.addEventListener('input', aplicarMascaraTempo);
                    } else if (modoSelecionado === 'Contagem') {
                        campoIndice.type = 'number';
                        campoIndice.placeholder = 'Digite a contagem';
                        campoIndice.disabled = false;
                        // se já havia um índice (em segundos), remove conversão e mostra o número bruto
                        campoIndice.value = selecionado.indice ?? '';
                    } else {
                        campoIndice.type = 'text';
                        campoIndice.placeholder = '';
                        campoIndice.disabled = true;
                        campoIndice.value = selecionado.indice ?? '';
                    }
                }

                if (campoId) campoId.value = selecionado.id ?? '';

                // Adiciona listener para quando o exercício mudar (usa opcoes.modo_de_contagem)
                const selectExercicio = document.getElementById('notas_exercicio');
                if (selectExercicio) {
                    selectExercicio.removeEventListener('change', onChangeExercicioBound);
                    onChangeExercicioBound = function (e) { onChangeExercicio(e, opcoes.modo_de_contagem); };
                    selectExercicio.addEventListener('change', onChangeExercicioBound);
                }
            });

            // bound holder to allow removeEventListener above
            let onChangeExercicioBound = null;

            /**
             * Atualiza o campo índice conforme o exercício selecionado e seu modo de contagem
             */
            function onChangeExercicio(event, modoContagemArray) {
                const campoIndice = document.getElementById('notas_indice');
                const select = event.target;
                const exercicioSelecionado = select.value;

                if (!campoIndice) return;

                // Limpa o valor atual
                campoIndice.value = '';

                // Encontra o modo de contagem correspondente
                let modo = null;
                if (Array.isArray(modoContagemArray)) {
                    modoContagemArray.forEach(item => {
                        if (typeof item === 'object' && item !== null) {
                            const chave = Object.keys(item)[0];
                            if (chave == exercicioSelecionado) modo = item[chave];
                        }
                    });
                }

                // Remove listener anterior e aplica novo comportamento
                campoIndice.removeEventListener('input', aplicarMascaraTempo);

                if (modo === 'Tempo') {
                    campoIndice.type = 'text';
                    campoIndice.placeholder = 'mm:ss';
                    campoIndice.disabled = false;
                    campoIndice.value = ''; // já pediu para limpar
                    campoIndice.addEventListener('input', aplicarMascaraTempo);
                } else if (modo === 'Contagem') {
                    campoIndice.type = 'number';
                    campoIndice.placeholder = 'Digite a contagem';
                    campoIndice.disabled = false;
                    campoIndice.value = '';
                } else {
                    campoIndice.type = 'text';
                    campoIndice.placeholder = '';
                    campoIndice.disabled = true;
                    campoIndice.value = '';
                }
            }

            /**
             * Preenche um <select> considerando tanto arrays quanto dicionários
             */
            function preencherSelect(id, valorSelecionado, opcoes) {
                const select = document.getElementById(id);
                if (!select || !opcoes) return;

                select.innerHTML = '';

                opcoes.forEach(item => {
                    if (typeof item === 'object' && item !== null) {
                        Object.entries(item).forEach(([key, value]) => {
                            const option = document.createElement('option');
                            option.value = key;
                            option.textContent = value;
                            if (key == valorSelecionado) option.selected = true;
                            select.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = item;
                        option.textContent = item;
                        if (item == valorSelecionado) option.selected = true;
                        select.appendChild(option);
                    }
                });
            };



            // ---- MÁSCARA DE TEMPO ----
            function aplicarMascaraTempo(event) {
                let v = event.target.value.replace(/\D/g, '');
                if (v.length > 4) v = v.slice(0, 4);
                if (v.length >= 3) v = v.slice(0, 2) + ':' + v.slice(2);
                const parts = v.split(':');
                if (parts[1]?.length == 1 && parseInt(parts[1]) > 5) parts[1] = '';
                event.target.value = parts.join(':');
            }

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
                    console.log(str);
                    return JSON.parse(str);
                } catch {
                    console.warn('Falha ao parsear JSON:', str);
                    return null;
                }
            }
        });
    </script>

</div>