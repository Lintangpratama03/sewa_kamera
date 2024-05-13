get_data(_id);

$(".status").select2({
	theme: "bootstrap4",
});

$(".status").on("change", function () {
	filterData();
});

function filterData() {
	$("#example").DataTable().search($(".status").val()).draw();
}

function get_data($id) {
	$.ajax({
		url: base_url + _controller + "/get_data/"+ $id,
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
					{ data: "nama_user",className: "text-center" },
					{ data: "nama_produk",className: "text-center" },
					{ data: "kategori",className: "text-center" },
					{ data: "type",className: "text-center" },
					{
                        data: "rating",
                        className: "text-center",
                        render: function (data, type, row) {
                            return generateStars(data);
                        }
                    }
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
function generateStars(average_rating) {
    var stars = '';
    var fullStars = Math.floor(average_rating);
    var halfStar = (average_rating - fullStars) >= 0.5 ? 1 : 0;
    var emptyStars = 5 - fullStars - halfStar;
    for (var i = 0; i < fullStars; i++) {
        stars += '<i class="fa fa-star" style="color: yellow;"></i>';
    }
    if (halfStar === 1) {
        stars += '<i class="fa fa-star-half-alt" style="color: yellow;"></i>';
    }
    for (var j = 0; j < emptyStars; j++) {
        stars += '<i class="fa fa-star" style="color: #ddd;"></i>';
    }
    return stars;
}