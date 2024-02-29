get_profil();
function delete_error() {
	$("#error-nama").hide();
	$("#error-email").hide();
	$("#error-telepon").hide();
	$("#error-alamat").hide();
	$("#error-image").hide();
	$("#error-card").hide();
	$("#error-akses").hide();
	$("#error-username").hide();
	$("#error-password").hide();
	$("#error-password1").hide();
}
$(function () {
	bsCustomFileInput.init();
});

$(".akses").select2({
	theme: "bootstrap4",
});

$(".akses").on("change", function () {
	filterData();
});

function filterData() {
	$("#example").DataTable().search($(".akses").val()).draw();
}

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


function get_profil() {
	delete_error();
	$.ajax({
		url: base_url + "/" + _controller + "/get_profil",
		method: "GET",
		dataType: "json",
		success: function (data) {
			$("[name='id']").val(data[0].id);
			$("[name='nama']").val(data[0].name);
			$("[name='email']").val(data[0].email);
			$("[name='telepon']").val(data[0].phone_number);
			$("[name='akses']").val(data[0].akses);
			$("[name='alamat']").val(data[0].address);
			var nama = data[0].image;
			imageProfil.innerHTML = `<img src="${base_url}assets/image/user/${nama}" class="img-thumbnail" alt="Preview Image" style="width: 100px; height: auto;">`;
			var ktp = data[0].ktp;
			imageKTP.innerHTML = `<img src="${base_url}assets/image/user/${ktp}" class="img-thumbnail" alt="Preview Image" style="width: 100px; height: auto;">`;
			$("[name='username']").val(data[0].username);
			$("[name='password']").val(data[0].password);
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

function edit_profil() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	formData.append("nama", $("[name='nama']").val());
	formData.append("email", $("[name='email']").val());
	formData.append("telepon", $("[name='telepon']").val());
	formData.append("alamat", $("[name='alamat']").val());
	formData.append("username", $("[name='username']").val());
	formData.append("password1", $("[name='password1']").val());

	var imageInput = $("[name='image']")[0];
	if (imageInput.files.length > 0) {
		formData.append("image", imageInput.files[0]);
	}
	var imageInput1 = $("[name='ktp']")[0];
	if (imageInput1.files.length > 0) {
		formData.append("ktp", imageInput1.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/edit_profil",
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
				delete_error();
				$("body").append(response.success);
				get_profil();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function previewImage1(event, imageContainerId) {
	const imageInput = event.target;
	const imageContainer = document.getElementById(imageContainerId);

	if (imageInput.files && imageInput.files[0]) {
		const reader = new FileReader();

		reader.onload = function (e) {
			imageContainer.innerHTML = `<img src="${e.target.result}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;">`;
		};

		reader.readAsDataURL(imageInput.files[0]);
	} else {
		imageContainer.innerHTML = "";
	}
}
