<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="<?= site_url('Dashboard') ?>" class="brand-link">
            <!--begin::Brand Text-->
            <span class="brand-text font-weight-light">TAF</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                <?php $this->load->view('templates/fixos/items_sidebar', ['route' => 'Dashboard', 'name_page' => 'Dashboard', 'icon' => 'bi bi-clipboard-data']) ?>
                <?php $this->load->view('templates/fixos/items_sidebar', ['route' => 'Usuarios', 'name_page' => 'Usuários', 'icon' => 'bi bi-person-circle']) ?>
                <?php $this->load->view('templates/fixos/items_sidebar', ['route' => 'FaixasEtarias', 'name_page' => 'Faixas Etárias', 'icon' => 'fa-solid fa-calendar']) ?>
                <?php $this->load->view('templates/fixos/items_sidebar', ['route' => 'Exercicios', 'name_page' => 'Tipos de Exercícios', 'icon' => 'fa-solid fa-dumbbell']) ?>
                <?php $this->load->view('templates/fixos/items_sidebar', ['route' => 'ExerciciosRealizados', 'name_page' => 'Exercícios Realizados', 'icon' => 'fa-solid fa-person-swimming']) ?>
                <?php $this->load->view('templates/fixos/items_sidebar', ['route' => 'Notas', 'name_page' => 'Notas', 'icon' => 'fa-solid fa-file-pen']) ?>
                <?php $this->load->view('templates/fixos/items_sidebar', ['route' => 'Demo', 'name_page' => 'AdminLTE Demo', 'icon' => 'bi bi-clipboard-data']) ?>
                <?php $this->load->view('templates/fixos/items_sidebar', ['route' => 'Home', 'name_page' => 'Home', 'icon' => 'bi bi-clipboard-data']) ?>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>