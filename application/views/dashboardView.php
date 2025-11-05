<section class="content">
  <div class="container-fluid">

    <div class="row mt-4 mw-50 mh-50">
      <?php $this->load->view('templates/small_box', ['color' => 'bg-info', 'value' => count($usuarios), 'title' => 'Usuários', 'icon' => 'fa-solid fa-user']) ?>
      <?php $this->load->view('templates/small_box', ['color' => 'bg-success', 'value' => count($faixas_etarias), 'title' => 'Faixas Etárias', 'icon' => 'fa-solid fa-calendar']) ?>
      <?php $this->load->view('templates/small_box', ['color' => 'bg-warning', 'value' => count($tipos_exercicios), 'title' => 'Tipos de Exercícios', 'icon' => 'fa-solid fa-dumbbell']) ?>
      <?php $this->load->view('templates/small_box', ['color' => 'bg-danger', 'value' => count($notas_exercicios), 'title' => 'Notas dos Exercícios', 'icon' => 'fa-solid fa-file-pen']) ?>
      <?php $this->load->view('templates/small_box', ['color' => 'bg-info', 'value' => count($exercicios_realizados['registro_exercicios']), 'title' => 'Exercícios Contabilizados', 'icon' => 'fa-solid fa-person-swimming']) ?>
      <?php $this->load->view('templates/small_box', ['color' => 'bg-success', 'value' => count($resultados['resultados']), 'title' => 'Resultados dos Exercícios', 'icon' => 'fa-solid fa-medal']) ?>

      <!--Tabela dos resultados-->
    </div>
  </div>
</section>