<section class="content">
    <div class="container-fluid">
        <div class="col-md-6">
            <form method="POST" action="<?= site_url('Login/efetuar_login') ?>" class="needs-validation">
                <?php $this->load->view('templates/inputs/input_texto', ['id' => 'nome', 'title' => 'Nome']) ?>
                <?php $this->load->view('templates/inputs/input_texto', ['id' => 'senha', 'title' => 'Senha']) ?>
                <button type="submit" class="btn btn-primary me-1">Fazer Login</button>
            </form>
        </div>
    </div>
</section>