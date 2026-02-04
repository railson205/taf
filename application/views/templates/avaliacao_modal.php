<div class="modal fade" id="<?= $id ?>" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Avaliação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <strong>Nome:</strong> <span id="m_nome"></span><br>
                    <strong>Sexo:</strong> <span id="m_sexo"></span><br>
                    <strong>Faixa Etária:</strong> <span id="m_faixa"></span><br>
                    <strong>Grupo:</strong> <span id="m_grupo"></span>
                </div>

                <hr>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Exercício</th>
                                <th>Modo</th>
                                <th>Índice</th>
                                <th>Nota</th>
                                <?php if (in_array($_SESSION['usuario']['nivel'], ['Avaliador', 'Administrador'])): ?>
                                    <th>Ações</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="modal_exercicios_body">
                            <!-- preenchido via JS -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const modal = document.getElementById('avaliacao_modal');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const registro = JSON.parse(button.getAttribute('data-registro'));

                //Filtragem de notas
                //id, indice, sexo, exercicio_id, faixa_id, modo_contagem, valor_nota
                const notas = JSON.parse(button.getAttribute('data-notas'));


                // Dados básicos
                document.getElementById('m_nome').textContent = registro.nome ?? '-';
                document.getElementById('m_sexo').textContent = registro.sexo ?? '-';
                document.getElementById('m_faixa').textContent = registro.faixa_etaria ?? '-';
                document.getElementById('m_grupo').textContent = registro.grupo_faixa ?? '-';

                const tbody = document.getElementById('modal_exercicios_body');
                tbody.innerHTML = '';

                if (!registro.exercicios || !registro.exercicios.length) {
                    tbody.innerHTML = `<tr><td colspan="5" class="text-center">Nenhum exercício</td></tr>`;
                    return;
                }

                registro.exercicios.forEach(exec => {
                    tbody.innerHTML += `
                <tr>
                    <td>${exec.nome_do_exercicio}</td>
                    <td>${exec.modo_de_contagem}</td>
                    <td>${exec.modo_de_contagem === 'Tempo'
                            ? segundosParaTempo(exec.indice)
                            : exec.indice}</td>
                    <td>${exec.valor_nota}</td>
                    <?php if (in_array($_SESSION['usuario']['nivel'], ['Avaliador', 'Administrador'])): ?>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#resultado_modal_editar"
                                data-selecionado='${JSON.stringify({
                                nome: registro.nome,
                                usuario_id: registro.usuario_id,
                                sexo: registro.sexo,
                                faixa_etaria: registro.faixa_etaria,
                                grupo_da_faixa_etaria: registro.grupo_faixa,
                                id: exec.resultado_id,
                                exercicio_id: exec.exercicio_id,
                                indice_id: exec.indice_id,
                                exercicio: exec.nome_do_exercicio,
                                indice: exec.indice
                            })}'
                            data-opcoes='${JSON.stringify({ Índice: filtragemDeIndices(notas, { sexo: registro.sexo, exercicio_id: exec.exercicio_id, faixa_id: registro.faixa_id }) })}'
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    <?php endif; ?>
                </tr>
            `;
                });
            });

        });

        function filtragemDeIndices(notas, filtro) {
            //Formatação dos indices: ID|Indice
            //Filtra os indices por sexo, exercicio_id e faixa_id do usuário
            const arrayFiltrado = notas.filter(item=>
                item.sexo===filtro.sexo && item.exercicio_id===filtro.exercicio_id && item.faixa_id===filtro.faixa_id
            );

            //Formata o array filtrado para ID|Índice
            const arrayFormatado=arrayFiltrado.map(item=>`${item.id}|${item.modo_de_contagem=='Tempo' ? segundosParaTempo(item.indice) : item.indice}`);
            return arrayFormatado;
        }

        function segundosParaTempo(seg) {
            const min = Math.floor(seg / 60);
            const s = seg % 60;
            return `${String(min).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        }
    </script>

</div>