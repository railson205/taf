<?php
function input_component($label, $name, $type, $feedback, $placeholder = '', $options = [], $options_id = [], $extra = '')
{
  $inputId = "input" . ucfirst($name);
  $addonId = "{$name}-addon";
  $step = '';

  switch ($type) {
    case 'email':
      $icon = 'bi-envelope-fill';
      break;
    case 'password':
      $icon = 'bi-lock-fill';
      break;
    case 'text':
      $icon = 'bi-type';
      break;
    case 'date':
      $icon = 'bi-calendar-fill';
      break;
    case 'select':
      $icon = 'bi-card-list';
      break;
    case 'number':
      $icon = 'bi-123';
      break;
    case 'time':
      $icon = 'bi-stopwatch';
      $type = 'text';
      $extra .= " oninput=\"let v=this.value.replace(/\\D/g,'');if(v.length>4)v=v.slice(0,4);if(v.length>=3)v=v.slice(0,2)+':'+v.slice(2);this.value=v;\"";
      break;
    case 'float':
      $icon = 'bi-123';
      $step = '0.01';
      $extra .= " oninput=\"
        // Remove tudo que não seja número ou ponto
        this.value = this.value.replace(/[^0-9.]/g,'');
        // Substitui vírgula por ponto
        this.value = this.value.replace(',', '.');
        // Mantém apenas o primeiro ponto
        const parts = this.value.split('.');
        if(parts.length > 2) this.value = parts[0] + '.' + parts.slice(1).join('');
    \"";
      break;
    default:
      $icon = '';
      break;
  }


  $html = "
    <div class='mb-3'>
      <label for='$inputId' class='form-label'>$label</label>
      <div class='input-group has-validation'>
        <span class='input-group-text' id='$addonId'><i class='bi $icon'></i></span>";

  if (!empty($options) && is_array($options)) {
    $html .= "<select class='form-select' id='$inputId' name='$name' aria-describedby='$addonId' required $extra>
                    <option value=''>Selecione...</option>";
    if (empty($options_id)) {
      foreach ($options as $texto) {
        $html .= "<option value='$texto'>$texto</option>";
      }
    } else {
      foreach ($options as $valor => $texto) {
        $html .= "<option value='$options_id[$valor]'>$texto</option>";
      }
    }

    $html .= "</select>";
  } else {
    $html .= "<input type='$type' step='$step' class='form-control' id='$inputId' name='$name'
                    placeholder='$placeholder' aria-describedby='$addonId' required $extra>";
  }

  $html .= "
        <div class='invalid-feedback'>$feedback</div>
      </div>
    </div>";

  return $html;
}
