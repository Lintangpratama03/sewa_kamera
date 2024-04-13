
$(".status").select2({
    theme: "bootstrap4",
});

$("#status").on("change", function () {
    filterData();
});

$("#kategori").select2({
	dropdownParent: $("#exampleModal"),
	theme: "bootstrap4"
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

// console.log(_id);
get_data(_id);

function get_data($id) {
    delete_error();
    $.ajax({
        url: base_url + _controller + "/get_data/"+ $id,
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
                    { data: "nama_produk" },
                    { data: "jumlah" },
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
                    {
                        data: "status_pr",
                        className: "text-center",
                        render: function (data, type, row) {
                        if (data == "0") {
                            return '<button type="button" class="btn btn-outline-warning btn-xs">Belum Kembali</button>';
                        } else if (data == "1") {
                            return '<button type="button" class="btn btn-outline-success btn-xs">Kembali</button>';
                        } else if (data == "2") {
                            return '<button type="button" class="btn btn-outline-danger btn-xs">Tidak Kembali</button>';
                        }
                        },
                    },
                    {
                        data: "status",
                        className: "text-center",
                        render: function (data, type, row) {
                                return (
                                    ' <button class="btn btn-info" data-toggle="modal" data-target="#exampleModal" title="detail" onclick="submit(' +
                                    row.id_pr +
                                    ')"><i class="fa-solid fa-eye"></i></button>'
                                );
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
        url: base_url + "/" + _controller + "/get_data_id",
        dataType: "json",
        success: function (hasil) {
            $("[name='id']").val(hasil[0].id);
            $("[name='id_d']").val(hasil[0].id_d);
            $("[name='judul']").val(hasil[0].nama_produk);
            $("[name='jml']").val(hasil[0].jml);
            $("[name='harga']").val(hasil[0].harga);
            $("[name='type']").val(hasil[0].type);
            $("[name='keterangan']").val(hasil[0].ket_d);
            $("#kategori").val(hasil[0].id_category).trigger("change");
            var nama = hasil[0].image;
            imagePreview.innerHTML = `<br><img src="${base_url}assets/image/produk/${nama}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;">`;
        },
    });
}

function terima_data() {
    var formData = new FormData();
    formData.append("id_d", $("[name='id_d']").val());
    formData.append("keterangan", $("[name='keterangan']").val());
    $.ajax({
        type: "POST",
        url: base_url + _controller + "/kembali_data",
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
                get_data(_id);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + error);
        },
    });
}
function tolak_data() {
    var formData = new FormData();
    formData.append("id_d", $("[name='id_d']").val());
    formData.append("keterangan", $("[name='keterangan']").val());
    $.ajax({
        type: "POST",
        url: base_url + _controller + "/tdk_kembali",
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
                get_data(_id);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + error);
        },
    });
}

get_data_penyewa(_id);
function get_data_penyewa(id) {
    //console.log(id);
    $.ajax({
        url: base_url + _controller + "/get_data_penyewa/"+ id,
        method: "GET",
        dataType: "json",
        success: function (data) {
            // console.log(data);
            $("#nama").val(data[0].name);
            $("#telepon").val(data[0].phone_number);
            $("#alamat").val(data[0].address);
            var imageUrl = base_url + "assets/image/user/" + data[0].image;
            $("#imageProfil").html(`<img src="${imageUrl}" class="img-thumbnail" style="width: 100px; height: auto;">`);
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr.statusText);
        },
    });
}

get_data_denda(_id);
$(document).ready(function() {
    // Ambil nilai dari input telat, denda, dan total
    var telatInput = $("#telat");
    var dendaInput = $("#denda");
    var totalInput = $("#total");

    // Hitung total
    function calculateTotal() {
        var telat = parseFloat(telatInput.val()) || 0;
        var denda = parseFloat(dendaInput.val()) || 0;
        var total = telat + denda;
        totalInput.val(total);
    }

    // Event listener untuk perubahan nilai input telat dan denda
    telatInput.on("input", calculateTotal);
    dendaInput.on("input", function() {
        var denda = parseFloat(dendaInput.val()) || 0;
        dendaInput.val(denda);
        calculateTotal();
    });

    // Hitung total saat halaman dimuat
    get_data_denda(_id, function() {
        calculateTotal();
    });
});

function get_data_denda(id, callback) {
    $.ajax({
        url: base_url + _controller + "/get_data_denda/" + id,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data && data.length > 0 && data[0].telat != null && data[0].telat !== "") {
                $("#telat").val(data[0].telat);
                $("#denda").val(data[0].ganti_rugi);
            } else {
                var today = new Date();
                today.setHours(0, 0, 0, 0);
                var tenggat = new Date(data[0].tgl_tenggat);
                tenggat.setHours(0, 0, 0, 0);
                var denda = 0;
                if (today > tenggat) {
                    var timeDiff = today.getTime() - tenggat.getTime();
                    var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    denda = daysDiff * 10000;
                    $("#telat").val(denda);
                    $("#denda").val(0);
                } else {
                    $("#telat").val(0);
                    $("#denda").val(0);
                }
            }
            callback();
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log(xhr.statusText);
        },
    });
}