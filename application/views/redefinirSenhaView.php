<section class="content">
    <div class="container-fluid">
        <div class="col-md-6">
            <form method="POST" action="<?= site_url("RedefinirSenha/salvarNovaSenha") ?>"
                class="needs-validation">
                <?php
                $this->load->view('templates/inputs/input_texto', ['id' => 'senha', 'title' => 'Senha']);
                $this->load->view('templates/inputs/input_texto', ['id' => 'senhaConfirmacao', 'title' => 'Confirmar Senha']);
                ?>
                
                <button type="submit" class="btn btn-primary me-1">Redefinir Senha</button>
            </form>
        </div>
    </div>
</section>