document.addEventListener("DOMContentLoaded", function () {
	document.querySelectorAll(".datatable").forEach((table) => {
		// Se já foi iniciado, destrói primeiro
		if ($.fn.DataTable.isDataTable(table)) {
			$(table).DataTable().destroy();
		}

		$(table).DataTable({
			responsive: false,
			autoWidth: false,

			pageLength: 20,

			language: {
				url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json",
			},

			columnDefs: [
				{
					orderable: false,
					targets: -1,
				},
			],
		});
	});
});
