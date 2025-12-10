<section class="content">
    <div class="container-fluid">
        <?php
        $alert_type = $this->session->flashdata('alert_type');
        $alert_message = $this->session->flashdata('alert_message');

        if ($alert_message): ?>
            <script>
                Swal.fire({
                    title: "Aviso",
                    text: "<?= $alert_message ?>",
                    icon: "<?= $alert_type ?>", // success, error, warning, info
                    confirmButtonText: "OK"
                });
            </script>
        <?php endif; ?>
        <div class="col-md-6">
            <form method="POST" action="<?= site_url('Login/efetuar_login') ?>" class="needs-validation">
                <?php
                $this->load->view('templates/inputs/input_texto', ['id' => 'email', 'title' => 'Email']);
                $this->load->view('templates/inputs/input_texto', ['id' => 'senha', 'title' => 'Senha', 'type' => 'password'])
                    ?>
                <button type="submit" class="btn btn-primary me-1">Fazer Login</button>
            </form>
            <a href="<?= site_url('EsqueceuSenha') ?>">Esqueceu a senha?</a>
        </div>
    </div>
    
</section>