get_data();
function showModal(imageUrl) {
    $('#imageModal').modal('show');
    $('#modalImage').attr('src', imageUrl);
}
$(function () {
	bsCustomFileInput.init();
});


document.addEventListener("DOMContentLoaded", function () {
	var showPasswordCheckbox = document.getElementById("showPasswordCheckbox");
	var passwordInput = document.getElementById("password");
	var passwordInput1 = document.getElementById("password1");

	showPasswordCheckbox.addEventListener("change", function () {
		if (showPasswordCheckbox.checked) {
			passwordInput.type = "text";
			passwordInput1.type = "text";
		} else {
			passwordInput.type = "password";
			passwordInput1.type = "password";
		}
	});
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

function previewImage1(event) {
	const imageInput = event.target;
	const imagePreview = document.getElementById("imagePreview1");

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
	const imagePreview1 = document.getElementById("imagePreview1");
	$("[name='id']").val("");
	$("[name='nama']").val("");
	$("[name='email']").val("");
	$("[name='telepon']").val("");
	$("[name='alamat']").val("");
	$("[name='image']").val("");
	$("[name='username']").val("");
	$("[name='password']").val("");
	$("[name='password1']").val("");
	imagePreview.innerHTML = "";
	imagePreview1.innerHTML = "";
}

function delete_error() {
	$("#error-nama").hide();
	$("#error-email").hide();
	$("#error-telepon").hide();
	$("#error-alamat").hide();
	$("#error-image").hide();
	$("#error-card").hide();
	$("#error-username").hide();
	$("#error-password").hide();
	$("#error-password1").hide();
}

$("#hapusAdmin").on("show.bs.modal", function (e) {
	var button = $(e.relatedTarget);
	var id = button.data("id");
	var modalButton = $(this).find("#btn-hapus");
	modalButton.attr("onclick", "delete_data(" + id + ")");
});

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
					{ data: "name" },
					{ data: "email" },
					{ data: "address" },
					{ data: "akses" },
					{
						data: "image",
						className: "text-center",
						render: function (data, type, row) {
							var imageUrl = base_url + "assets/image/user/" + data;
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
								'<button class="btn btn-primary" data-toggle="modal" data-target="#konfirmasiModal" title="edit" onclick="submit(' +
								row.id +
								')"><i class="fa-solid fa-pen-to-square"></i></button> ' +
								'<button class="btn btn-warning" data-toggle="modal" data-target="#hapusAdmin" title="hapus" data-id="' +
								row.id +
								'"><i class="fa-solid fa-trash-can"></i></button>'
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

function submit(x) {
	var label = document.getElementById("passwordLabel");
	var label1 = document.getElementById("passwordLabel1");
	var input = document.getElementById("password");
	var input1 = document.getElementById("password1");
	const imagePreview = document.getElementById("imagePreview");
	const imagePreview1 = document.getElementById("imagePreview1");

	if (x == "tambah") {
		$("#btn-tambah").show();
		input.readOnly = false;
		label.textContent = "Password";
		label1.textContent = "Ulangi";
		input1.placeholder = "Ulangi Password";
	} else {
		$("#btn-konfirmasi").show();
		$("#btn-tolak").show();
		input.readOnly = true;

		$.ajax({
			type: "POST",
			data: "id=" + x,
			url: base_url + "/" + _controller + "/get_data_id",
			dataType: "json",
			success: function (hasil) {
				$("[name='id']").val(hasil[0].id);
				$("[name='nama']").val(hasil[0].name);
				$("[name='email']").val(hasil[0].email);
				$("[name='telepon']").val(hasil[0].phone_number);
				$("[name='alamat']").val(hasil[0].address);
				var profil = hasil[0].image;
				imagePreview.innerHTML = `<img src="${base_url}assets/image/user/${profil}" class="img-thumbnail" alt="Preview Image" style="width: 100px; height: auto;">`;
				var ktp = hasil[0].ktp;
				imagePreview1.innerHTML = `<img src="${base_url}assets/image/ktp/${ktp}" class="img-thumbnail" alt="Preview Image" style="width: 100px; height: auto;">`;
				$("[name='username']").val(hasil[0].username);
				$("[name='password']").val(hasil[0].password);
			},
		});
	}
	delete_form();
	delete_error();
}

function insert_data() {
	var formData = new FormData();
	formData.append("nama", $("[name='nama']").val());
	formData.append("email", $("[name='email']").val());
	formData.append("telepon", $("[name='telepon']").val());
	formData.append("alamat", $("[name='alamat']").val());
	formData.append("username", $("[name='username']").val());
	formData.append("password", $("[name='password']").val());
	formData.append("password1", $("[name='password1']").val());

	var imageInput = $("[name='image']")[0];
	if (imageInput.files.length > 0) {
		formData.append("image", imageInput.files[0]);
	}

	var imageInput1 = $("[name='card']")[0];
	if (imageInput1.files.length > 0) {
		formData.append("card", imageInput1.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + "/" + _controller + "/insert_data",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_error();
			if (response.errors) {
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

function konfirmasi_data() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	$.ajax({
		type: "POST",
		url: base_url + _controller + "/konfirmasi_data",
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
				$("#konfirmasiModal").modal("hide");
				$("body").append(response.success);
				get_data();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function tolak_data() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	$.ajax({
		type: "POST",
		url: base_url + _controller + "/tolak_data",
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
				$("#konfirmasiModal").modal("hide");
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
		url: base_url + _controller + "/delete_data",
		success: function (response) {
			console.log(response);
			$("body").append(response.success);
			get_data();
		},
	});
}
