<?php $this->load->view('templates/fixos/header', isset($title) ? compact('title') : []); ?>

<div class="main-layout d-flex gap-3">

  <!-- Sidebar -->
<!--Adicione no array abaixo o nome dos controller que não vão possuir sidebar -->
  <?php if (in_array($title, ["Login",'EsqueceuSenha'])): ?>
    <?php $this->load->view('templates/fixos/sidebar'); ?>
  <?php endif; ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper flex-grow-1 p-4">
    <!-- Content Header (título e breadcrumb) -->
    <div class="content-header pb-3 border-bottom mb-3">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="m-0"><?= isset($title) ? $title : 'Página' ?></h1>
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="<?= site_url('ControladorCondicional') ?>">Home</a></li>
          <li class="breadcrumb-item active"><?= isset($title) ? $title : '' ?></li>
        </ol>
      </div>
    </div>


    <!-- Main Content -->
    <section class="content">
      <div class="content-container p-3">
        <?php $this->load->view($view_name, isset($view_data) ? $view_data : []); ?>
      </div>
    </section>
  </div>
</div>

<?php $this->load->view('templates/fixos/footer'); ?>