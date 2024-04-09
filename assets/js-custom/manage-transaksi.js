get_data();

$(".status").select2({
    theme: "bootstrap4",
});

$("#status").on("change", function () {
    filterData();
});

$(function () {
    $('#tanggalWrapper').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#tanggal').on('change', function () {
        filterData();
    });
});

function filterData() {
    var table = $("#example").DataTable();
    var statusFilter = $(".status").val();
    var dateFilter = $("#tanggal").val();

    table.columns(4).search(statusFilter).draw();
    table.columns(1).search(dateFilter ? dateFilter : "").draw();
}

// $("#cekPesan").on("show.bs.modal", function (e) {
//     var button = $(e.relatedTarget);
//     var id = button.data("id");
//     var modalButton = $(this).find("#btn-success");
//     modalButton.attr("onclick", "cek_ulasan(" + id + ")");
// });

function previewImage(event) {
    const imageInput = event.target;
    const imagePreview = document.getElementById("imagePreview");

    if (imageInput.files && imageInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            imagePreview.innerHTML = `<a href="${e.target.result}" data-fancybox="gallery"><img src="${e.target.result}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;"></a>`;
        };
        $("#error-image").html("");

        reader.readAsDataURL(imageInput.files[0]);
    } else {
        imagePreview.innerHTML = "";
    }
}

function delete_form() {
    $("[name='id']").val("");
    $("[name='name']").val("");
    $("[name='message']").val("");
    $("[name='reply']").val("");
}

function delete_error() {
    $("#error-reply").hide();
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
                    { data: "tgl_booking_date" },
                    { data: "name" },
                    { data: "keterangan" },
                    {
                        data: "status",
                        className: "text-center",
                        render: function (data, type, row) {
                            if (data == "1") {
                                return '<button type="button" class="btn btn-block btn-danger">Belum dicek</button>';
                            } else if (data == "2") {
                                return '<button type="button" class="btn btn-block btn-warning">Proses Bayar</button>';
                            } else if (data == "3") {
                                return '<button type="button" class="btn btn-block btn-success">Sudah Bayar</button>';
                            }
                        },
                    },
                    {
                        data: "status",
                        className: "text-center",
                        render: function (data, type, row) {
                            if (data == "1") {
                                return (
                                    ' <button class="btn btn-info" data-toggle="modal" data-target="#detailPesan" title="detail" onclick="submit(' +
                                    row.id +
                                    ')"><i class="fa-solid fa-eye"></i></button>'
                                );
                            } else if (data == "2") {
                                return (
                                    ' <button class="btn btn-info" data-toggle="modal" data-target="#detailPesan" title="detail" onclick="submit(' +
                                    row.id +
                                    ')"><i class="fa-solid fa-eye"></i></button>'
                                );
                            } else if (data == "3") {
                                return (
                                    ' <button class="btn btn-info" data-toggle="modal" data-target="#detailPesan" title="detail" onclick="submit(' +
                                    row.id +
                                    ')"><i class="fa-solid fa-eye"></i></button>' +
                                    ' <button class="btn btn-success" data-toggle="modal" data-target="#detailBayar" title="balas" onclick="submit(' +
									row.id +
									')"><i class="fa-solid fa-shopping-cart"></i></button>'
                                );
                            }
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

var detailTable;

function submit(x) {
    $.ajax({
        type: "POST",
        data: "id=" + x,
        url: base_url + _controller + "/get_data_id",
        dataType: "json",
        success: function (hasil) {
            $("[name='id']").val(hasil[0].id);
            $("[name='nama']").val(hasil[0].name);
            var nama = hasil[0].image;
            imagePreview.innerHTML = `<br><a href="${base_url}assets/image/user/${nama}" data-fancybox="gallery"><img src="${base_url}assets/image/user/${nama}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;"></a>`;

            if (!$.fn.DataTable.isDataTable('#detailTable')) {
                detailTable = $('#detailTable').DataTable({
                    destroy: true,
                    data: hasil,
                    columns: [
                        { data: 'tgl_booking_date' },
                        { data: 'nama_produk' },
                        {
                            data: "image_produk",
                            className: "text-center",
                            render: function (data, type, row) {
                                var imageUrl = base_url + "assets/image/produk/" + data;
                                return (
                                    '<a href="' +
                                    imageUrl +
                                    '" data-fancybox="gallery"><img src="' +
                                    imageUrl +
                                    '" style="max-width: 100px; max-height: 400px;"></a>'
                                );
                            },
                        },
                    ],
                    initComplete: function () {
                        $("th").css("text-align", "center");
                    },
                });
            } else {
                detailTable.clear().rows.add(hasil).draw();
            }

            if (hasil[0].status === "1") {
                $('#btn-ubah').show();
			} else if (hasil[0].status === "3") {
                $('#btn-ubah').hide();
                $('#btn-tolak').hide();
            } else{
                $('#btn-ubah').hide();
			}
        },
    });
    delete_form();
    delete_error();
}

function terima_data() {
    var formData = new FormData();
    formData.append("id", $("[name='id']").val());
    $.ajax({
        type: "POST",
        url: base_url + _controller + "/terima_data",
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
                $("#detailPesan").modal("hide");
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
            delete_error();
            if (response.errors) {
                for (var fieldName in response.errors) {
                    $("#error-" + fieldName).show();
                    $("#error-" + fieldName).html(response.errors[fieldName]);
                }
            } else if (response.success) {
                $("#detailPesan").modal("hide");
                $("body").append(response.success);
                get_data();
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + error);
        },
    });
}