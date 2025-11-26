<aside class="main-sidebar sidebar-dark-primary elevation-4" style="width:250px;min-width:250px;max-width:250px;">
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
    <div class="sidebar ">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">

                <?php switch ($_SESSION['usuario']['nivel']) {
                    case 'Administrador':
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'Dashboard', 'name_page' => 'Dashboard', 'icon' => 'bi bi-clipboard-data']);
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'Seguranca', 'name_page' => 'Segurança', 'icon' => 'fa fa-lock']);
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'Usuarios', 'name_page' => 'Usuários', 'icon' => 'bi bi-person-circle']);
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'FaixasEtarias', 'name_page' => 'FaixasEtárias', 'icon' => 'fa-solid fa-calendar']);
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'Exercicios', 'name_page' => 'Tipos de Exercícios', 'icon' => 'fa-solid fa-dumbbell']);
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'Notas', 'name_page' => 'Notas', 'icon' => 'fa-solid fa-file-pen']);
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'Resultados', 'name_page' => 'Resultados', 'icon' => 'fa-solid fa-person-swimming']);
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'Demo', 'name_page' => 'AdminLTE Demo', 'icon' => 'bi bi-clipboard-data']);
                        break;
                    case 'Avaliador':
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'Resultados', 'name_page' => 'Resultados', 'icon' => 'fa-solid fa-person-swimming']);
                        break;
                    case 'Atleta':
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'Resultados', 'name_page' => 'Resultados', 'icon' => 'fa-solid fa-person-swimming']);
                        break;
                    default:
                        $this->load->view('templates/fixos/items_sidebar', ['route' => 'Dashboard', 'name_page' => 'Dashboard', 'icon' => 'bi bi-clipboard-data']);
                        break;
                } ?>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>