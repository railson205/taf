<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste DataTable</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

</head>
<body class="p-4">

    <div class="container">

        <h2>Teste do DataTable</h2>
        <p>Esta tabela não usa AdminLTE. Apenas Bootstrap + DataTables.</p>

        <table class="table table-striped table-hover table-bordered datatable" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Modo</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>Corrida 2400m</td>
                    <td>Tempo</td>
                    <td><button class="btn btn-sm btn-primary">Editar</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Flexão de Braço</td>
                    <td>Contagem</td>
                    <td><button class="btn btn-sm btn-primary">Editar</button></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Natação 100m</td>
                    <td>Tempo</td>
                    <td><button class="btn btn-sm btn-primary">Editar</button></td>
                </tr>
            </tbody>
        </table>

    </div>

    <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 5,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json"
                },
                columnDefs: [
                    { orderable: false, targets: -1 } // Ações não ordena
                ]
            });
        });
    </script>

</body>
</html>
