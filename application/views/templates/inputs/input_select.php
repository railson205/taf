<div class="mb-3">
    <label for="<?= $id ?>" class="form-label"><?= $title ?></label>
    <select class="form-select" id="<?= $id ?>" name="<?= $id ?>" required <?= isset($disabled) ? "disabled='{$disabled}'" : '' ?>>
        <option value=""><?= $placeholder ?></option>

        <?php
        // Normaliza o array para lidar com arrays de arrays associativos
        foreach ($options as $key => $option) {
            // Caso: cada elemento seja outro array associativo (ex: [[1 => '18-24'], [3 => '25-29']])
            if (is_array($option) && array_is_assoc($option)) {
                foreach ($option as $val => $text) {
                    echo "<option value=\"{$val}\">{$text}</option>";
                }
            }
            // Caso: array associativo comum (ex: ['M' => 'Masculino'])
            elseif (array_is_assoc($options)) {
                echo "<option value=\"{$key}\">{$option}</option>";
            }
            // Caso: array simples (ex: ['Masculino', 'Feminino'])
            else {
                echo "<option value=\"{$option}\">{$option}</option>";
            }
        }
        ?>

    </select>
</div>