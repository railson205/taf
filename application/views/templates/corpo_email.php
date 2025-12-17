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
            color:
                <?= $cor_titulo ?>
            ;
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

        <table width="100%" cellpadding="0" cellspacing="0"
            style="margin-top:15px; border-collapse: collapse; font-family: Arial, sans-serif; font-size:14px;">

            <!-- TÍTULO -->
            <tr>
                <td colspan="2" style="background-color:#f1f3f5; padding:10px; font-weight:bold; text-align:center;">
                    Detalhes do Resultado do Exercício
                </td>
            </tr>

            <!-- DADOS FIXOS DO EXERCÍCIO -->
            <tr>
                <td style="padding:8px; border:1px solid #ddd; width:40%;"><strong>Exercício</strong></td>
                <td style="padding:8px; border:1px solid #ddd;">
                    <?= $exercicio['nome_exercicio'] ?>
                </td>
            </tr>

            <tr>
                <td style="padding:8px; border:1px solid #ddd;"><strong>Modo de Contagem</strong></td>
                <td style="padding:8px; border:1px solid #ddd;">
                    <?= $exercicio['modo_contagem'] ?>
                </td>
            </tr>


            <?php foreach ($resultados as $i => $resultado):?>
                
                <!-- SEPARADOR (caso seja log) -->
                <?php if (count($resultados) > 1): ?>
                    <tr>
                        <td colspan="2" style="background:#e9ecef; padding:6px; font-weight:bold; text-align:center;">
                            Registro <?= $i + 1 ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td style="padding:8px; border:1px solid #ddd;"><strong>Índice Realizado</strong></td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        <?= $exercicio['modo_contagem'] === 'Tempo'
                            ? segundos_para_tempo($resultado['indice'])
                            : $resultado['indice'] ?>
                    </td>
                </tr>

                <tr>
                    <td style="padding:8px; border:1px solid #ddd;"><strong>Nota</strong></td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        <?= $resultado['valor_nota'] ?>
                    </td>
                </tr>

                <tr>
                    <td style="padding:8px; border:1px solid #ddd;"><strong>Avaliado em</strong></td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        <?= !empty($resultado['avaliado_em'])
                            ? date('d/m/Y H:i', strtotime($resultado['avaliado_em']))
                            : '-' ?>
                    </td>
                </tr>

                <tr>
                    <td style="padding:8px; border:1px solid #ddd;"><strong>Atualizado em</strong></td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        <?= !empty($resultado['atualizado_em'])
                            ? date('d/m/Y H:i', strtotime($resultado['atualizado_em']))
                            : '-' ?>
                    </td>
                </tr>

                <?php if (!empty($resultado['observacao'])): ?>
                    <tr>
                        <td style="padding:8px; border:1px solid #ddd;"><strong>Observação</strong></td>
                        <td style="padding:8px; border:1px solid #ddd;">
                            <?= $resultado['observacao'] ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>

        <p><?= $mensagem_final ?></p>

        <div class="footer">
            Sistema CBMCE<br>
            Este é um e-mail automático, não responda.
        </div>
    </div>

</body>

</html>