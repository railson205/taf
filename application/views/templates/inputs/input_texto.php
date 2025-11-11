<?php
(function (
    $id,
    $title,
    $type = 'text',
    $placeholder = '',
    $pattern = '',
    $min = '',
    $max = '',
    $minlength = '',
    $maxlength = '',
    $disabled = false,
    $icon_span = ''
) {
?>
    <div class="mb-3">
        <label for="<?= $id ?>" class="form-label"><?= $title ?></label>
        <div class="input-group">
            <?php if (!empty($icon_span)): ?>
                <span class="input-group-text"><?= $icon_span ?></span>
            <?php endif; ?>
            <input
                type="<?= htmlspecialchars($type) ?>"
                class="form-control"
                id="<?= htmlspecialchars($id) ?>"
                name="<?= htmlspecialchars($id) ?>"
                placeholder="<?= htmlspecialchars($placeholder) ?>"
                required
                <?= $disabled ? 'disabled' : '' ?>
                <?= $minlength !== '' ? "minlength='{$minlength}'" : '' ?>
                <?= $maxlength !== '' ? "maxlength='{$maxlength}'" : '' ?>
                <?= $pattern !== '' ? "pattern='{$pattern}'" : '' ?>
                <?= $min !== '' ? "min='{$min}'" : '' ?>
                <?= $max !== '' ? "max='{$max}'" : '' ?>
            >
        </div>
    </div>
<?php
})(
    $id ?? '',
    $title ?? '',
    $type ?? 'text',
    $placeholder ?? '',
    $pattern ?? '',
    $min ?? '',
    $max ?? '',
    $minlength ?? '',
    $maxlength ?? '',
    $disabled ?? false,
    $icon_span ?? ''
);
?>
