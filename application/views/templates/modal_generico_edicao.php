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
                            <?php $nome_e_tipo=explode('|', $c); debug($nome_e_tipo)?>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-1">
                                            <?= $nome_e_tipo[0] ?>
                                        </h6>
                                        <?php if (): ?>
                                            <select id="<?=$id?>_<?=$nome_e_tipo[0]?>" name="<?=$id?>_<?=$nome_e_tipo[0]?>_editar"></select>
                                                <?php else: ?>
                                                    <input type="text" id="<?=$id?>_<?=$nome_e_tipo[0]?>" name="<?=$id?>_<?=$nome_e_tipo[0]?>_editar" class="form-control">
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
        document.addEventListener('show.bs.modal', function (event) {
            const modal = event.target;
            if (!modal.classList.contains('modal-edicao-generica')) return;

            const button = event.relatedTarget;
            if (!button) return;

            const data = parseJSON(button.dataset.selecionado || '{}');

            // Preenchimento automático
            modal.querySelectorAll('[data-field]').forEach(el => {
                const key = el.dataset.field;
                if (!(key in data)) return;

                const value = data[key] ?? '';

                if (el.tagName === 'INPUT' || el.tagName === 'SELECT' || el.tagName === 'TEXTAREA') {
                    el.value = value;
                } else {
                    el.textContent = value;
                }
            });

            // Select com opções vindas do botão (ex: data-nivel-options)
            modal.querySelectorAll('select[data-field]').forEach(select => {
                const field = select.dataset.field;
                const optionsAttr = `options${capitalize(field)}`;
                const rawOptions = button.dataset[optionsAttr];

                if (!rawOptions) return;

                select.innerHTML = '';
                rawOptions.split(',').forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt;
                    option.textContent = opt;
                    select.appendChild(option);
                });

                select.value = data[field] ?? '';
            });
        });

        function parseJSON(str) {
            try {
                return JSON.parse(str);
            } catch {
                console.warn('JSON inválido:', str);
                return {};
            }
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

    </script>
</div>