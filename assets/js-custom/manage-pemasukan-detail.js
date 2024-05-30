get_data(_tahun,_bulan);

$(".status").select2({
	theme: "bootstrap4",
});

$(".status").on("change", function () {
	filterData();
});

function filterData() {
	$("#example").DataTable().search($(".status").val()).draw();
}

function get_data($tahun,$bulan) {
	$.ajax({
		url: base_url + _controller + "/get_data/"+ $tahun+"/"+$bulan,
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
					{ data: "tgl_transaksi",className: "text-center" },
					{ data: "nama_pelanggan",className: "text-center" },
					{ data: "total_transaksi",className: "text-center" },
					{ data: "total_denda",className: "text-center" },
					{ data: "total_pemasukan",className: "text-center" }
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