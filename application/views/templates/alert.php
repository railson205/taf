<?php
if (!empty($alerts)):
    foreach ($alerts as $alert):
        $conteudo = $this->session->flashdata($alert['key']);
        if (!$conteudo) continue;

        $type = $alert['type'] ?? 'primary';
        $icons = [
            'danger' => 'fas fa-times-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'success' => 'fas fa-check-circle',
            'primary' => 'fas fa-info-circle'
        ];
        $icon = $icons[$type] ?? $icons['primary'];
        ?>
        <div class="col-md-12 mb-3">
            <div class="alert alert-<?= $type ?>" role="alert">
                <i class="<?= $icon ?> me-2"></i> <?= $conteudo ?>.
            </div>
        </div>
    <?php
    endforeach;
endif;
?>
