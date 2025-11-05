<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? $title : 'Painel' ?></title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- OverlayScrollbars -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.css') ?>">

<!-- Styles Globais-->
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/stylesGlobais.css') ?>">


</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
      <a href="<?= base_url('Dashboard') ?>" class="navbar-brand">
        <span class="brand-text fw-bold text-primary">Meu Painel</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="#" class="nav-link"><i class="fas fa-user"></i> Perfil</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link"><i class="fas fa-sign-out-alt"></i> Sair</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Content Wrapper -->
  <div class="content-wrapper p-3">
