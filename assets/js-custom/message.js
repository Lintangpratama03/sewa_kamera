function delete_form() {
	$("[name='nama']").val("");
	$("[name='email']").val("");
	$("[name='subjek']").val("");
	$("[name='pesan']").val("");
}

function delete_error() {
	$("#error-nama").html("");
	$("#error-email").html("");
	$("#error-subjek").html("");
	$("#error-pesan").text("");
}

function insert_message() {
	var formData = new FormData();
	formData.append("nama", $("[name='nama']").val());
	formData.append("email", $("[name='email']").val());
	formData.append("subjek", $("[name='subjek']").val());
	formData.append("pesan", $("[name='pesan']").val());

	$.ajax({
		type: "POST",
		url: base_url + "/" + _controller + "/insert_message",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_error();
			if (response.errors) {
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				delete_error();
				delete_form();
				window.location.href = "location_contact";
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}
