<section class="content">
    <div class="container-fluid">
        <div class="col-md-6">
            <form method="POST" action="<?= site_url('EsqueceuSenha/enviarEmailRecuperacao') ?>" class="needs-validation">
                <?php
                $this->load->view('templates/inputs/input_texto', ['id' => 'email', 'title' => 'Email']);
                ?>
                <button type="submit" class="btn btn-primary me-1">Enviar email de recuperação</button>
            </form>
        </div>
    </div>
</section>