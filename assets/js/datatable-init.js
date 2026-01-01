document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.datatable').forEach(table => {

        if (!$.fn.DataTable.isDataTable(table)) {
            $(table).DataTable({
                responsive: {
                    details: {
                        type: 'column'
                    }
                },
                autoWidth: false,
                pageLength: 5,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
                },
                columnDefs: [
                    {
                        className: 'dtr-control',
                        orderable: false,
                        targets: 0
                    },
                    {
                        orderable: false,
                        targets: -1
                    }
                ]
            });
        }

    });

});
