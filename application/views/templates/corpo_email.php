<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }
        .container {
            background: #ffffff;
            max-width: 600px;
            margin: auto;
            border-radius: 6px;
            padding: 20px;
        }
        h2 {
            color: <?= $cor_titulo ?>;
        }
        .info {
            margin-top: 15px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><?= $titulo ?></h2>

    <p>Olá <strong><?= $nome_destinatario ?></strong>,</p>

    <p><?= $mensagem_principal ?></p>

    <div class="info">
        <p><strong>Exercício:</strong> <?= $exercicio ?></p>
        <p><strong>Resultado:</strong> <?= $resultado ?></p>

        <?php if (!empty($observacao)): ?>
            <p><strong>Observação:</strong> <?= $observacao ?></p>
        <?php endif; ?>
    </div>

    <p><?= $mensagem_final ?></p>

    <div class="footer">
        Sistema CBMCE<br>
        Este é um e-mail automático, não responda.
    </div>
</div>

</body>
</html>
