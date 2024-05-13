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
function previewImage1(event) {
    const imageInput1 = event.target;
    const imagePreview1 = document.getElementById("imagePreview1");

    if (imageInput1.files && imageInput1.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            imagePreview1.innerHTML = `<a href="${e.target.result}" data-fancybox="gallery"><img src="${e.target.result}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;"></a>`;
        };
        $("#error-image").html("");

        reader.readAsDataURL(imageInput1.files[0]);
    } else {
        imagePreview1.innerHTML = "";
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
                    { data: "tgl_booking_date",className: "text-center" },
                    { data: "name",className: "text-center" },
                    { data: "tgl_pinjam",className: "text-center" },
                    {
                        data: "status",
                        className: "text-center",
                        render: function (data, type, row) {
                            if (data == "booking") {
                                return '<button type="button" class="btn btn-block bg-gradient-danger btn-xs">Belum dicek</button>';
                            } else if (data == "terverifikasi") {
                                return '<button type="button" class="btn btn-block bg-gradient-warning btn-xs">Terverifikasi</button>';
                            } else if (data == "bayar") {
                                return '<button type="button" class="btn btn-block bg-gradient-info btn-xs">Proses Bayar</button>';
                            } else if (data == "lunas") {
                                return '<button type="button" class="btn btn-block bg-gradient-success btn-xs">Terbayar</button>';
                            }
                        },
                    },
                    {
                        data: "status",
                        className: "text-center",
                        render: function (data, type, row) {
                            if (data == "booking") {
                                return (
                                    ' <button class="btn btn-info" data-toggle="modal" data-target="#detailPesan" title="detail" onclick="submit(' +
                                    row.id +
                                    ')"><i class="fa-solid fa-eye"></i></button>'
                                );
                            } else if (data == "terverifikasi") {
                                return (
                                    ' <button class="btn btn-info" data-toggle="modal" data-target="#detailPesan" title="detail" onclick="submit(' +
                                    row.id +
                                    ')"><i class="fa-solid fa-eye"></i></button>'
                                );
                            } else if (data == "bayar") {
                                return (
                                    ' <button class="btn btn-info" data-toggle="modal" data-target="#detailPesan" title="detail" onclick="submit(' +
                                    row.id +
                                    ')"><i class="fa-solid fa-eye"></i></button>' +
                                    ' <button class="btn btn-warning" data-toggle="modal" data-target="#detailBayar" title="detail-bayar" onclick="submit(' +
									row.id +
									')"><i class="fa-solid fa-shopping-cart"></i></button>'
                                );
                            } else if (data == "lunas") {
                                return (
                                    ' <button class="btn btn-info" data-toggle="modal" data-target="#detailPesan" title="detail" onclick="submit(' +
                                    row.id +
                                    ')"><i class="fa-solid fa-eye"></i></button>' +
                                    ' <button class="btn btn-warning" data-toggle="modal" data-target="#detailBayar" title="detail-bayar" onclick="submit(' +
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
            imagePreview1.innerHTML = `<br><a href="${base_url}assets/image/user/${nama}" data-fancybox="gallery"><img src="${base_url}assets/image/user/${nama}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;"></a>`;

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

            $.ajax({
                type: "POST",
                data: "id=" + x,
                url: base_url + _controller + "/get_detail_bayar",
                dataType: "json",
                success: function (detail_bayar) {
                    if (!$.fn.DataTable.isDataTable('#detailTable2')) {
                        detailTable = $('#detailTable2').DataTable({
                            destroy: true,
                            data: detail_bayar,
                            columns: [
                                { data: 'status_bayar' },
                                { data: 'va_number' },
                                { data: 'tanggal_expire' },
                            ],
                            initComplete: function () {
                                $("th").css("text-align", "center");
                            },
                        });
                    } else {
                        detailTable.clear().rows.add(detail_bayar).draw();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + error);
                }
            });

            if (hasil[0].status === "booking") {
                $('#btn-ubah').show();
			} else if (hasil[0].status === "lunas") {
                $('#btn-ubah').hide();
                $('#btn-tolak').hide();
			} else if (hasil[0].status === "bayar") {
                $('#btn-ubah').hide();
                $('#btn-tolak').hide();
                $('#btn-ambil').hide();
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

function ambil_data() {
    var formData = new FormData();
    formData.append("id", $("[name='id']").val());
    $.ajax({
        type: "POST",
        url: base_url + _controller + "/ambil_data",
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
                $("#detailBayar").modal("hide");
                $("body").append(response.success);
                get_data();
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + error);
        },
    });
}