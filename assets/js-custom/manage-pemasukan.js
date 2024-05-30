get_data();

$(".status").select2({
	theme: "bootstrap4",
});

$(".status").on("change", function () {
	filterData();
});

function filterData() {
	$("#example").DataTable().search($(".status").val()).draw();
}

function get_data() {
	$.ajax({
		url: base_url + _controller + "/get_data",
		method: "GET",
		dataType: "json",
		success: function (data) {
			console.log(data);
			var table = $("#example").DataTable({
				destroy: true,
				data: data,
				columns: [
					{
						data: null,
						className: "text-center",
						render: function (data, type, row, meta) {
							return meta.row + 1;
						},
					},
					{ data: "bulan",className: "text-center" },
					{ data: "tahun",className: "text-center" },
					{ data: "total_pemasukan",className: "text-center" },
					{
						data: "status",
						className: "text-center",
						render: function (data, type, row) {
							return (
								'<a href="' + base_url + 'manage-pemasukan-detail/' + row.tahun + '/' + row.bulan + '" class="btn btn-info" title="detail"><i class="fa-solid fa-eye"></i></a>'
							);    
						},
					},
				],
				initComplete: function () {
					$("th").css("text-align", "center");
				},
			});
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}