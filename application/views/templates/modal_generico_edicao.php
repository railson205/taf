<?php $id = normalizarString($nome_modal); ?>

<div class="modal fade modal-edicao-generica" id="<?= $id ?>_modal_editar" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-header modal-edicao text-white">
                <h5 class="modal-title">Editar <?= $nome_modal ?></h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">
                <form method="POST" action="<?= site_url($endpoint) ?>">

                    <!-- id vem do JSON -->
                    <input type="hidden" name="<?= $id ?>_id" data-field="id">

                    <div class="row g-3">
                        <?php foreach ($campos as $c): ?>
                            <?php $nome_e_tipo = explode('|', $c); ?>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-1">
                                            <?= $nome_e_tipo[0] ?>
                                        </h6>
                                        <!-- Define se vai ser select ou input-->
                                        <?php if ($nome_e_tipo[1] == "Select"): ?>
                                            <select id="<?= $id ?>_<?= $nome_e_tipo[0] ?>"
                                                name="<?= $id ?>_<?= $nome_e_tipo[0] ?>_editar"></select>
                                        <?php else: ?>
                                            <input type="text" id="<?= $id ?>_<?= $nome_e_tipo[0] ?>"
                                                name="<?= $id ?>_<?= $nome_e_tipo[0] ?>_editar" class="form-control">
                                        <?php endif; ?>

                                        <p id="<?= $id ?>_<?= normalizarString($c) ?>" class="mb-0 fw-bold"></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">
                        Salvar
                    </button>
                </form>
            </div>

        </div>
    </div>
    <script>
        const nomes_e_tipos = <?= json_encode($campos) ?>;
        const id = "<?= $id ?>";
        document.addEventListener('show.bs.modal', function (event) {
            const modal = event.target;
            if (!modal.classList.contains('modal-edicao-generica')) return;

            const button = event.relatedTarget;
            if (!button) return;

            // ---- CAPTURA DOS DADOS JSON ----
            const selecionado = parseJSON(button.getAttribute('data-selecionado')) || {};
            const opcoes = parseJSON(button.getAttribute('data-opcoes')) || {};

            console.log(selecionado);
            console.log(opcoes);
            console.log(nomes_e_tipos);

            nomes_e_tipos.forEach(e => {
                const [nome, tipo] = e.split('|');
                console.log(selecionado[normalizarString(nome)]);

                if (tipo == 'Select') {
                    const campoSelect = document.getElementById(id +'_'+ nome);
                    campoSelect.innerHTML = '';

                    opcoes[nome].forEach(item => {
                        const option = document.createElement('option');
                        //Mudar depois
                        option.value=item;
                        //Colocar opção se tiver modo de contagem
                        option.textContent=item;
                        if(selecionado[normalizarString(nome)]==item)option.selected=true;
                        campoSelect.appendChild(option);
                    });

                } else {
                    modal.querySelector('#' + id + '_' + nome).value = selecionado[normalizarString(nome)];
                }

            });
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

        //Função para normalizar string
        function normalizarString(str) {
            if (!str) return '';

            return str
                .toString()
                .normalize('NFD')                 // separa acentos
                .replace(/[\u0300-\u036f]/g, '')  // remove acentos
                .replace(/[^a-zA-Z0-9\s]/g, '')   // remove caracteres especiais
                .trim()
                .toLowerCase()
                .replace(/\s+/g, '_');            // espaços → _
        }


    </script>
</div>