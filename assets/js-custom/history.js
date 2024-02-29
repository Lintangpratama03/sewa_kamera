get_data();

function delete_2() {
	$("#error-ktp2").hide();
	$("#error-pengantar2").hide();
	$("#error-keterangan2").hide();
}

function delete_3() {
	$("#error-ktp3").hide();
	$("#error-pengantar3").hide();
	$("#error-keterangan3").hide();
}

function delete_1() {
	$("#error-kk1").hide();
	$("#error-kia1").hide();
	$("#error-akta1").hide();
	$("#error-pengantar1").hide();
	$("#error-keterangan1").hide();
}

function get_data() {
	$.ajax({
		url: base_url + _controller + "/get_data_history",
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
					{ data: "letter_name" },
					{ data: "submit_date" },
					{
						data: "status",
						className: "text-center",
						render: function (data, type, row) {
							if (data == "1") {
								return '<button type="button" class="btn btn-block btn-info">Belum dicek</button>';
							} else if (data == "2") {
								return '<button type="button" class="btn btn-block btn-danger">Tidak terpenuhi</button>';
							} else if (data == "3") {
								return '<button type="button" class="btn btn-block btn-primary">Terpenuhi</button>';
							} else if (data == "4") {
								return '<button type="button" class="btn btn-block btn-success">Dapat diambil</button>';
							}
						},
					},
					{
						data: null,
						className: "text-center",
						render: function (data, type, row) {
							if (row.status == "2") {
								if (row.id_letter == "1") {
									return (
										'<button class="btn btn-dark" data-toggle="modal" data-target="#modalDetail" title="detail" onclick="submit(' +
										row.id +
										')"><i class="fa-solid fa-eye"></i></button> ' +
										'<button class="btn btn-warning" data-toggle="modal" data-target="#edit1" title="edit" onclick="edit(' +
										row.id_requirements +
										')"><i class="fa-solid fa-edit"></i></button> '
									);
								} else if (row.id_letter == "2") {
									return (
										'<button class="btn btn-dark" data-toggle="modal" data-target="#modalDetail" title="detail" onclick="submit(' +
										row.id +
										')"><i class="fa-solid fa-eye"></i></button> ' +
										'<button class="btn btn-warning" data-toggle="modal" data-target="#edit2" title="edit" onclick="edit(' +
										row.id_requirements +
										')"><i class="fa-solid fa-edit"></i></button> '
									);
								} else if (row.id_letter == "3") {
									return (
										'<button class="btn btn-dark" data-toggle="modal" data-target="#modalDetail" title="detail" onclick="submit(' +
										row.id +
										')"><i class="fa-solid fa-eye"></i></button> ' +
										'<button class="btn btn-warning" data-toggle="modal" data-target="#edit3" title="edit" onclick="edit(' +
										row.id_requirements +
										')"><i class="fa-solid fa-edit"></i></button> '
									);
								}
							} else {
								return (
									'<button class="btn btn-dark" data-toggle="modal" data-target="#modalDetail" title="detail" onclick="submit(' +
									row.id +
									')"><i class="fa-solid fa-eye"></i></button> '
								);
							}
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
	$.ajax({
		type: "POST",
		data: "id=" + x,
		url: base_url + _controller + "/get_data_id",
		dataType: "json",
		success: function (hasil) {
			$("[name='id']").val(hasil[0].id);
			$("[name='nama']").val(hasil[0].name);
			$("[name='letter']").val(hasil[0].letter_name);
			$("[name='date1']").val(hasil[0].submit_date);
			$("[name='date2']").val(hasil[0].finish_date);
			$("[name='keterangan']").val(hasil[0].keterangan);
		},
	});
	delete_form();
}

function edit(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		url: base_url + _controller + "/get_data_history_id",
		dataType: "json",
		success: function (hasil) {
			$("[name='id']").val(hasil[0].id_requirements);
		},
	});
	delete_form();
}

function edit_1() {
	delete_1();
	var kiaInput = $("[name='kia1']")[0];
	var pengantarInput = $("[name='pengantar1']")[0];
	var kkInput = $("[name='kk1']")[0];
	var aktaInput = $("[name='akta1']")[0];

	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	if (kiaInput.files.length > 0) {
		formData.append("kia", kiaInput.files[0]);
	}
	if (pengantarInput.files.length > 0) {
		formData.append("pengantar", pengantarInput.files[0]);
	}
	if (kkInput.files.length > 0) {
		formData.append("kk", kkInput.files[0]);
	}
	if (aktaInput.files.length > 0) {
		formData.append("akta", aktaInput.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/edit_1",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_1();
			if (response.errors) {
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				$("#modalAjukan_1").modal("hide");
				window.location.href = "history";
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
			console.log("Response Text:", xhr.responseText);
		},
	});
}

function edit_2() {
	delete_2();
	var ktpInput = $("[name='ktp2']")[0];
	var pengantarInput = $("[name='pengantar2']")[0];

	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	if (ktpInput.files.length > 0) {
		formData.append("ktp", ktpInput.files[0]);
	}
	if (pengantarInput.files.length > 0) {
		formData.append("pengantar", pengantarInput.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/edit_2",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_2();
			if (response.errors) {
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				$("#modalAjukan_2").modal("hide");
				window.location.href = "history";
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
			console.log("Response Text:", xhr.responseText);
		},
	});
}

function edit_3() {
	delete_3();
	var ktpInput = $("[name='ktp3']")[0];
	var pengantarInput = $("[name='pengantar3']")[0];

	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	if (ktpInput.files.length > 0) {
		formData.append("ktp", ktpInput.files[0]);
	}
	if (pengantarInput.files.length > 0) {
		formData.append("pengantar", pengantarInput.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/edit_3",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_3();
			if (response.errors) {
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				$("#edit3").modal("hide");
				window.location.href = "history";
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
			console.log("Response Text:", xhr.responseText);
		},
	});
}
