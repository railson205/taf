<?php
// Função autoexecutável: cria escopo local isolado
(function ($id, $title, $options, $placeholder, $disabled = false) {
?>
    <div class="mb-3">
        <label for="<?= $id ?>" class="form-label"><?= $title ?></label>
        <select
            class="form-select"
            id="<?= $id ?>"
            name="<?= $id ?>"
            required
            <?= $disabled ? 'disabled' : '' ?>
        >
            <option value=""><?= $placeholder ?></option>

            <?php
            foreach ($options as $key => $option) {
                if (is_array($option) && array_is_assoc($option)) {
                    foreach ($option as $val => $text) {
                        echo "<option value=\"{$val}\">{$text}</option>";
                    }
                } elseif (array_is_assoc($options)) {
                    echo "<option value=\"{$key}\">{$option}</option>";
                } else {
                    echo "<option value=\"{$option}\">{$option}</option>";
                }
            }
            ?>
        </select>
    </div>
<?php
// Fim da função autoexecutável, passando os parâmetros vindos da view principal
})(
    $id ?? '',
    $title ?? '',
    $options ?? [],
    $placeholder ?? '',
    $disabled ?? false
);
?>
