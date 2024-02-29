get_data();
function get_data() {
	$.ajax({
		url: base_url + _controller + "/get_data",
		method: "GET",
		dataType: "json",
		success: function (data) {
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
					{ data: "name" },
					{ data: "phone_number" },
					{ data: "address" },
					{
						data: "image",
						className: "text-center",
						render: function (data, type, row) {
							var imageUrl = base_url + "assets/image/user/" + data;
							return (
								'<img src="' +
								imageUrl +
								'" style="max-width: 100px; max-height: 400px;">'
							);
						},
					},
				],
				initComplete: function () {
					// Set column titles alignment to center
					$("th").css("text-align", "center");
				},
			});
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}
