<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? $title : 'Painel' ?></title>

  <!-- ======== CSS PRINCIPAIS ======== -->

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- OverlayScrollbars -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css">

  <!-- AdminLTE CSS (deve vir ANTES do DataTables CSS) -->
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/stylesGlobais.css') ?>">

  <!-- ======== DATATABLES CSS (sempre por último entre os CSS) ======== -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css">

  <!-- DataTables Buttons -->
<link rel="stylesheet"
  href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

  <!-- ======== JS PRINCIPAIS ======== -->

  <!-- jQuery → NÃO adicionar aqui (AdminLTE já adiciona automaticamente no final da página) -->

  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js"></script>

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        <a href="<?= site_url('/') ?>" class="navbar-brand">
          <span class="brand-text fw-bold text-primary">Meu Painel</span>
        </a>
        <a href="<?= site_url('Demo') ?>" class="navbar-brand">
          <span class="brand-text fw-bold text-primary">Demo</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav ms-auto">
            <?php if (!$this->session->userdata('usuario')): ?>
              <li class="nav-item">
                <a href=<?= site_url('Login') ?> class="nav-link"> Login</a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="fas fa-user"></i> <?= $_SESSION['usuario']['nome'] ?></a>
              </li>
              <li class="nav-item">
                <a href=<?= site_url('Login/logout') ?> class="nav-link"><i class="fas fa-sign-out-alt"></i> Sair</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Content Wrapper -->
    <div class="content-wrapper p-3">