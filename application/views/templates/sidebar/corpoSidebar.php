<aside class="sidebar-dark-primary h-100 d-flex flex-column">

    <!-- BRAND -->
    <div class="d-flex justify-content-center">
        <a href="<?= site_url('Dashboard') ?>" class="brand-link">
            <span class="brand-text font-weight-light">TAF</span>
        </a>
    </div>

    <!-- SIDEBAR -->
    <nav class="sidebar flex-grow-1 overflow-auto mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

            <?php switchSideBar($this); ?>

        </ul>
    </nav>

</aside>