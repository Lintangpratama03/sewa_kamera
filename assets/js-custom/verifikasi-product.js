get_data();
function showModal(imageUrl) {
    $('#imageModal').modal('show');
    $('#modalImage').attr('src', imageUrl);
}
$(function () {
	bsCustomFileInput.init();
});
$("#kategori").select2({
	dropdownParent: $("#exampleModal"),
	theme: "bootstrap4"
});

$("#hapusProduct").on("show.bs.modal", function (e) {
	var button = $(e.relatedTarget);
	var id = button.data("id");
	var modalButton = $(this).find("#btn-hapus");
	modalButton.attr("onclick", "delete_data(" + id + ")");
});

function previewImage(event) {
	const imageInput = event.target;
	const imagePreview = document.getElementById("imagePreview");

	if (imageInput.files && imageInput.files[0]) {
		const reader = new FileReader();

		reader.onload = function (e) {
			imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;">`;
		};
		$("#error-image").html("");

		reader.readAsDataURL(imageInput.files[0]);
	} else {
		imagePreview.innerHTML = "";
	}
}

function delete_form() {
	const imagePreview = document.getElementById("imagePreview");
	$("[name='id']").val("");
	$("[name='judul']").val("");
	$("[name='deskripsi']").val("");
	$("[name='stok']").val("");
	$("[name='harga']").val("");
	$("[name='type']").val("");
	$("[name='ket']").val("");
	$("[name='image']").val("");
	imagePreview.innerHTML = "";
}

function delete_error() {
	$("#error-judul").hide();
	$("#error-image").hide();
	$("#error-deskripsi").hide();
	$("#error-stok").hide();
	$("#error-harga").hide();
	$("#error-type").hide();
	$("#error-ket").hide();
}

function get_data() {
	delete_error();
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
					{ data: "name_mitra" },
					{ data: "nama_produk" },
					{
                        data: "is_aktif",
                        className: "text-center",
                        render: function (data, type, row) {
                            if (data == "0") {
                                return '<button type="button" class="btn btn-block bg-gradient-warning btn-xs">Proses Verifikasi</button>';
                            } else if (data == "1") {
                                return '<button type="button" class="btn btn-block bg-gradient-success btn-xs">Terverifikasi</button>';
                            } 
							else if (data == "2") {
                                return '<button type="button" class="btn btn-block bg-gradient-danger btn-xs">Ditolak Verifikasi</button>';
                            } 
                        },
                    },
					{
						data: "image",
						className: "text-center",
						render: function (data, type, row) {
							var imageUrl = base_url + "assets/image/produk/" + data;
							return (
								'<img src="' +
								imageUrl +
								'" style="max-width: 100px; max-height: 400px; cursor: pointer;" onclick="showModal(\'' +
								imageUrl +
								'\')">'
							);
						},
					},
					{
						data: null,
						className: "text-center",
						render: function (data, type, row) {
							return (
								'<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" title="edit" onclick="submit(' +
								row.id +
								')"><i class="fa-solid fa-pen-to-square"></i></button> ' +
								'<button class="btn btn-warning" data-toggle="modal" data-target="#hapusProduct" title="hapus" data-id="' +
								row.id +
								'"><i class="fa-solid fa-trash-can"></i></button>'
							);
						},
					},
				],
				initComplete: function () {
					// Set column titles alignment to center
					$("th").css("text-align", "center");
		
					// Filter event listener
					$('#filterVerifikasi').on('change', function () {
						var filterValue = $(this).val();
						table.column(5).search(filterValue).draw();
					});
				},
			});
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

function submit(x) {
		$.ajax({
			type: "POST",
			data: "id=" + x,
			url: base_url + "/" + _controller + "/get_data_id",
			dataType: "json",
			success: function (hasil) {
				$("[name='id']").val(hasil[0].id);
				$("[name='judul']").val(hasil[0].nama_produk);
                $("[name='stok']").val(hasil[0].stok);
                $("[name='harga']").val(hasil[0].harga);
				$("[name='type']").val(hasil[0].type);
                $("[name='deskripsi']").val(hasil[0].deskripsi);
                $("[name='keterangan']").val(hasil[0].ket_aktif);
				$("#kategori").val(hasil[0].id_category).trigger("change");
                $("[name='ket']").val(hasil[0].ket);
				var nama = hasil[0].image;
				imagePreview.innerHTML = `<br><img src="${base_url}assets/image/produk/${nama}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;">`;
			},
		});
	delete_form();
	delete_error();
}

function edit_data() {
    var formData = new FormData();
    formData.append("id", $("[name='id']").val());
    formData.append("judul", $("[name='judul']").val());
    formData.append("deskripsi", $("[name='deskripsi']").val());
    formData.append("keterangan", $("[name='keterangan']").val());
    formData.append("type", $("[name='type']").val());
    formData.append("stok", $("[name='stok']").val());
    formData.append("harga", $("[name='harga']").val());
    formData.append("kategori", $("#kategori").val());
    var imageInput = $("[name='image']")[0];
    if (imageInput.files.length > 0) {
        formData.append("image", imageInput.files[0]);
    }

    var verifikasiValue = $("input[name='verifikasi']:checked").val();
    formData.append("is_aktif", verifikasiValue);

    $.ajax({
        type: "POST",
        url: base_url + _controller + "/edit_data",
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.errors) {
                delete_error();
                for (var fieldName in response.errors) {
                    $("#error-" + fieldName).show();
                    $("#error-" + fieldName).html(response.errors[fieldName]);
                }
            } else if (response.success) {
                $("#exampleModal").modal("hide");
                $("body").append(response.success);
                get_data();
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + error);
        },
    });
}

function delete_data(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		dataType: "json",
		url: base_url + _controller + "/delete_data",
		success: function (response) {
			console.log(response);
			$("body").append(response.success);
			get_data();
		},
	});
}
