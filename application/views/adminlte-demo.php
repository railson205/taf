<?php
/**
 * application/views/adminlte-full-demo.php
 *
 * Demo completa dos componentes do AdminLTE 4.
 * Use junto com templates: header.php, sidebar.php, footer.php
 *
 * Como usar:
 *  - Controller: carregar header, sidebar, este view e footer.
 *  - Ex.: $this->load->view('templates/header'); $this->load->view('templates/sidebar'); $this->load->view('adminlte-full-demo'); $this->load->view('templates/footer');
 *
 * Referências rápidas (procure na documentação quando precisar):
 *  - AdminLTE components: https://adminlte.io/docs/4.0/
 *  - Bootstrap 5: https://getbootstrap.com/docs/5.3/
 */
?>

<!-- ===========================
     ADMINLTE - DEMO COMPLETO
     =========================== -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="m-0">AdminLTE — Catálogo de Componentes</h1>
                <nav aria-label="breadcrumb">
                    <!-- Breadcrumbs -->
                    <!-- Doc: https://adminlte.io/docs/4.0/components/breadcrumbs.html -->
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= site_url('Dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Componentes</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- ALERTS -->
            <!-- Doc: https://adminlte.io/docs/4.0/components/alerts.html -->
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h5>Alerts</h5>
                    <div class="alert alert-primary" role="alert">
                        <i class="fas fa-info-circle me-2"></i> Alerta primário.
                    </div>
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i> Ação executada com sucesso.
                    </div>
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Atenção: verifique os dados.
                    </div>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-times-circle me-2"></i> Erro ao processar a requisição.
                    </div>
                </div>
            </div>

            <!-- BUTTONS & BADGES -->
            <!-- Doc: https://adminlte.io/docs/4.0/components/buttons.html -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5>Botões</h5>
                    <button class="btn btn-primary me-1"><i class="fas fa-plus me-1"></i>Novo</button>
                    <button class="btn btn-success me-1"><i class="fas fa-check me-1"></i>Salvar</button>
                    <button class="btn btn-danger me-1"><i class="fas fa-trash me-1"></i>Excluir</button>
                    <button class="btn btn-outline-secondary me-1">Neutro</button>
                    <button class="btn btn-sm btn-info me-1">Pequeno</button>
                </div>

                <div class="col-md-6 mb-4">
                    <h5>Badges & Pills</h5>
                    <span class="badge bg-primary me-1">Primary</span>
                    <span class="badge bg-success me-1">Success</span>
                    <span class="badge bg-danger me-1">Danger</span>
                    <span class="badge rounded-pill bg-info me-1">Pill</span>
                </div>
            </div>

            <!-- CARDS -->
            <!-- Doc: https://adminlte.io/docs/4.0/components/cards.html -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Card Simples</h3>
                            <div class="card-actions ms-auto">
                                <!-- Card tools (colapsar/remover) - adminlte widgets -->
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            Conteúdo do card. Cards são blocos reutilizáveis para agrupar informações.
                        </div>
                        <div class="card-footer">Rodapé do card</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Card Outline</h3>
                        </div>
                        <div class="card-body">
                            Card com borda de destaque (outline).
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Card com Imagem</h3>
                        </div>
                        <img src="<?= base_url('assets/img/placeholder.png') ?>" class="card-img-top" alt="placeholder">
                        <div class="card-body">
                            <p class="card-text">Exemplo com imagem no topo do card.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABS & ACCORDION -->
            <!-- Tabs doc: https://adminlte.io/docs/4.0/components/tabs.html -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <h5>Tabs</h5>
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#tab1" data-bs-toggle="tab">Tab
                                        1</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tab2" data-bs-toggle="tab">Tab 2</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#tab3" data-bs-toggle="tab">Tab 3</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">Conteúdo da Tab 1</div>
                                <div class="tab-pane" id="tab2">Conteúdo da Tab 2</div>
                                <div class="tab-pane" id="tab3">Conteúdo da Tab 3</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accordion (collapse) -->
                <!-- Doc Bootstrap collapse: https://getbootstrap.com/docs/5.3/components/collapse/ -->
                <div class="col-md-6">
                    <h5>Accordion</h5>
                    <div class="accordion" id="demoAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne">
                                    Item 1
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#demoAccordion">
                                <div class="accordion-body">Conteúdo do item 1.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo">
                                    Item 2
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#demoAccordion">
                                <div class="accordion-body">Conteúdo do item 2.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL, TOASTS, TOOLTIP -->
            <!-- Modal doc: https://getbootstrap.com/docs/5.3/components/modal/ -->
            <!-- Toasts doc: https://getbootstrap.com/docs/5.3/components/toasts/ -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <h5>Modal</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Abrir Modal
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Título do Modal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Corpo do modal — coloque formulários, confirmações, etc.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Fechar</button>
                                    <button type="button" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <h5>Toasts</h5>
                    <div class="d-flex">
                        <button id="btnShowToast" class="btn btn-info me-2">Mostrar Toast</button>
                        <div class="toast-container position-relative">
                            <!-- Toast será mostrado via JS (cópia abaixo para referência) -->
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <h5>Tooltips & Popovers</h5>
                    <button class="btn btn-secondary me-2" data-bs-toggle="tooltip" title="Tooltip de exemplo">Hover
                        Tooltip</button>
                    <button class="btn btn-secondary" data-bs-toggle="popover" title="Pop"
                        data-bs-content="Conteúdo do popover">Clique Popover</button>
                </div>
            </div>

            <!-- FORMS: inputs, input-groups, switches -->
            <!-- Doc forms: https://adminlte.io/docs/4.0/forms/general.html -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <h5>Formulário</h5>
                    <form>
                        <div class="mb-3">
                            <label for="nomeEx" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeEx" placeholder="Seu nome">
                        </div>

                        <div class="mb-3">
                            <label for="emailEx" class="form-label">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="email" class="form-control" id="emailEx" placeholder="email@exemplo.com">
                                <button class="btn btn-outline-secondary" type="button">Verificar</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleSelect" class="form-label">Cargo</label>
                            <select class="form-select" id="exampleSelect">
                                <option selected>Selecione...</option>
                                <option value="1">Administrador</option>
                                <option value="2">Usuário comum</option>
                                <option value="3">Convidado</option>
                            </select>
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="chkAtivo" checked>
                            <label class="form-check-label" for="chkAtivo">Ativo</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Range</label>
                            <input type="range" class="form-range" min="0" max="100" value="50">
                        </div>

                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>

                </div>

                <!-- Progress & Badges -->
                <div class="col-md-6">
                    <h5>Progress & Badges</h5>
                    <div class="mb-3">
                        <label class="form-label">Progresso</label>
                        <div class="progress" style="height:20px;">
                            <div class="progress-bar" role="progressbar" style="width: 65%;">65%</div>
                        </div>
                    </div>

                    <h6 class="mt-3">Small badges</h6>
                    <span class="badge bg-secondary me-1">Info</span>
                    <span class="badge bg-warning text-dark me-1">Aviso</span>
                    <span class="badge bg-danger me-1">Erro</span>
                </div>
            </div>

            <!-- TABLES -->
            <!-- Doc tables: https://adminlte.io/docs/4.0/components/tables.html -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>Tabela</h5>
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Perfil</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>João</td>
                                        <td>joao@ex.com</td>
                                        <td>Admin</td>
                                        <td><span class="badge bg-success">Ativo</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Maria</td>
                                        <td>maria@ex.com</td>
                                        <td>Usuário</td>
                                        <td><span class="badge bg-warning text-dark">Pendente</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <!-- Pagination -->
                            <ul class="pagination pagination-sm float-right m-0">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LIST GROUPS, MEDIA OBJECTS -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <h5>List Group</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Notificação 1 <span class="badge bg-primary">14</span>
                        </li>
                        <li class="list-group-item">Item simples</li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Mensagem <span class="badge bg-success">Nova</span>
                        </li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <h5>Media Object</h5>
                    <div class="d-flex align-items-start mb-3">
                        <img src="<?= base_url('assets/img/placeholder.png') ?>" alt="avatar" class="rounded me-3"
                            style="width:48px;">
                        <div>
                            <h6 class="mb-0">Usuário X</h6>
                            <small class="text-muted">Mensagem de exemplo</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- WIDGETS (small boxes) -->
            <div class="row mt-4 bg-info">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>
                            <p>Novas Ordens</p>
                        </div>
                        <div class="small-box-icon"><i class="fas fa-shopping-cart"></i></div>
                        <a href="#" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53<sup style="font-size:12px">%</sup></h3>
                            <p>Taxa de Crescimento</p>
                        </div>
                        <div class="small-box-icon"><i class="fas fa-chart-line"></i></div>
                        <a href="#" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>
                            <p>Usuários</p>
                        </div>
                        <div class="small-box-icon"><i class="fas fa-users"></i></div>
                        <a href="#" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Tickets</p>
                        </div>
                        <div class="small-box-icon"><i class="fas fa-ticket-alt"></i></div>
                        <a href="#" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- FOOTER EXAMPLE (inside content area) -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5>Observação</h5>
                        <p>Este arquivo é um catálogo local dos componentes do AdminLTE 4. Consulte a documentação
                            quando necessitar implementar algo específico.</p>
                        <small>
                            Links úteis:
                            <a href="https://adminlte.io/docs/4.0/" target="_blank">AdminLTE Docs</a> |
                            <a href="https://getbootstrap.com/docs/5.3/components/" target="_blank">Bootstrap
                                Components</a>
                        </small>
                    </div>
                </div>
            </div>

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<!-- =====================================================
     Inicializações JS específicas desse demo (toasts, tooltip)
     Coloque aqui scripts pequenos; footer.php já carrega libs.
     ===================================================== -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializa tooltips (Bootstrap)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (el) {
            new bootstrap.Tooltip(el);
        });

        // Inicializa popovers (Bootstrap)
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.forEach(function (el) {
            new bootstrap.Popover(el);
        });

        // Mostrar um toast programaticamente (exemplo)
        document.getElementById('btnShowToast')?.addEventListener('click', function () {
            // Cria o markup do toast
            const toastHTML = `
      <div class="toast align-items-center text-bg-info border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            Toast de exemplo — ação concluída.
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    `;
            const container = document.querySelector('.toast-container.position-relative');
            if (container) {
                container.insertAdjacentHTML('beforeend', toastHTML);
                const toastEl = container.querySelector('.toast:last-child');
                const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
                toast.show();
            }
        });

        // Exemplo: inicializar overlayScrollbars (se estiver disponível)
        if (typeof OverlayScrollbars !== 'undefined') {
            document.querySelectorAll('.sidebar, .content-wrapper').forEach(function (el) {
                // Inicialização mínima; consulte docs do overlayscrollbars para opções
                OverlayScrollbars(el, {});
            });
        }

        // Card widget (AdminLTE) já funciona se adminlte.js estiver carregado.
        // Ex: document.querySelector('[data-card-widget="collapse"]') dispara o colapso automático
    });
</script>