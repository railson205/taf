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

  <!-- AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.css') ?>">
  <!-- Styles Personalizados com base em AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/stylesGlobais.css') ?>">
  <!-- Styles Governo do Ceará -->
  <link rel="stylesheet" href="<?= base_url('assets/css/temaCeara.css') ?>">

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

  <!-- SweetAlert -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css">

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="<?= base_url('assets/js/drawer.js') ?>"></script>
  <script src="<?= base_url('assets/js/datatable-init.js') ?>"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <!-- HEADER -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

      <!-- BOTÃO SIDEBAR (SÓ MOBILE) -->
      <ul class="navbar-nav d-md-none">
        <li class="nav-item">
          <a class="nav-link" role="button" data-bs-toggle="modal" data-bs-target="#sidebar">
            <i class="fas fa-bars"></i>
          </a>
        </li>
      </ul>

      <!-- LINKS ESQUERDA -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="<?= site_url('/') ?>" class="nav-link">
            <img src="https://www.ceara.gov.br/wp-content/uploads/2023/10/logotipo-governo-do-ceara-2023.svg"
              alt="logotipo-governo-do-ceara-2023" width="100%" style="max-width: 420px;">
          </a>
        </li>
        <!-- Retirar depois -->
         <?php if(true):?>
        <li class="nav-item">
          <a href="<?= site_url('Teste') ?>" class="nav-link fw-bold hover-underline">
            Teste
          </a>
        </li>
        <?php endif;?>
        <!-- Retirar depois -->
      </ul>

      <!-- DIREITA -->
      <ul class="navbar-nav ms-auto">
        <?php if (!$this->session->userdata('usuario')): ?>
          <li class="nav-item">
            <a href="<?= site_url('Login') ?>" class="nav-link text-secondary">
              Login
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <span class="nav-link">
              <i class="fas fa-user"></i> <?= $_SESSION['usuario']['nome'] ?>
            </span>
          </li>
          <li class="nav-item">
            <a href="<?= site_url('Login/logout') ?>" class="nav-link text-danger fw-bold">
              <i class="fas fa-sign-out-alt fw-bold"></i> Sair
            </a>
          </li>
        <?php endif; ?>
      </ul>

    </nav>
    <!-- /HEADER -->

    <!-- CONTENT WRAPPER -->
    <div class="content-wrapper p-3">
      <div class="main-layout d-flex gap-3">


        <!--Adicione no array abaixo o nome dos controller que não vão possuir sidebar -->
        <?php if (!in_array($title, ["Login", 'Esqueceu a senha', 'Redefinir a senha'])) {

          if (isMobile()) {
            $this->load->view('templates/sidebar/modalSidebar', ['id' => 'sidebar']);
          } else {
            $this->load->view('templates/sidebar/corpoSidebar');

          }
        } ?>


        <!-- Content Wrapper -->
        <div class="content-wrapper flex-grow-1 p-4">
          <!-- Content Header (título e breadcrumb) -->
          <div class="content-header pb-3 border-bottom mb-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
              <h1 class="m-0"><?= isset($title) ? $title : 'Página' ?></h1>
              <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('ControladorCondicional') ?>" class="link">Home</a></li>
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

      <footer class="main-footer text-center small py-3">
        <strong>© <?= date('Y') ?> Meu Sistema</strong> - Desenvolvido com AdminLTE 4
      </footer>
    </div> <!-- ./wrapper -->

    <!-- jQuery CDN (obrigatório para DataTables funcionar) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- OverlayScrollbars -->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"></script>

    <!-- DataTables JS (só funciona DEPOIS do jQuery do AdminLTE carregar) -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

    <!-- Dependências -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Botões -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>


    <!-- AdminLTE -->
    <script src="<?= base_url('assets/adminlte/dist/js/adminlte.js') ?>"></script>
</body>

</html>