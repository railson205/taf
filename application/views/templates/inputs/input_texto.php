<div class="mb-3">
    <label for="<?= $id ?>" class="form-label"><?= $title ?></label>
    <div class="input-group">
        <?php if (!empty($icon_span)): ?>
            <span class="input-group-text"><?= $icon_span ?></span>
        <?php endif; ?>
        <input 
            type="<?= $type ?>" 
            class="form-control" 
            id="<?= $id ?>" 
            name="<?= $id ?>" 
            placeholder="<?= $placeholder ?>"
            required
            <?= isset($disabled) ? "disabled='{$disabled}'":''?>
            <?= isset($minlength) ? "minlength='{$minlength}'" : '' ?>
            <?= isset($maxlength) ? "maxlength='{$maxlength}'" : '' ?>
            <?= isset($pattern) ? "pattern='{$pattern}'" : '' ?>
            <?= isset($min) ? "min='{$min}'" : '' ?>
            <?= isset($max) ? "max='{$max}'" : '' ?>
        >
    </div>
</div>
