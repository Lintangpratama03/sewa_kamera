get_data();

$(".status").select2({
    theme: "bootstrap4",
});

$(".status").on("change", function () {
    filterData();
});

function filterData() {
    $("#example").DataTable().search($(".status").val()).draw();
}

function get_data() {
    $.ajax({
        url: base_url + _controller + "/get_data",
        method: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data);
            var table = $("#example").DataTable({
                destroy: true,
                data: data,
                columns: [
                    { data: null, className: "text-center", render: function (data, type, row, meta) { return meta.row + 1; } },
                    { data: "nama_pelanggan", className: "text-center" },
                    { 
                        data: "tgl_transaksi", 
                        className: "text-center",
                        render: function(data, type, row) {
                            return moment(data).format('DD/MM/YYYY');
                        }
                    },
                    { 
                        data: "total_transaksi", 
                        className: "text-right",
                        render: function(data, type, row) {
                            return 'Rp ' + Number(data).toLocaleString('id-ID');
                        }
                    },
                    { 
                        data: "total_denda", 
                        className: "text-right",
                        render: function(data, type, row) {
                            return 'Rp ' + Number(data).toLocaleString('id-ID');
                        }
                    },
                    { 
                        data: "total_pemasukan", 
                        className: "text-right",
                        render: function(data, type, row) {
                            return 'Rp ' + Number(data).toLocaleString('id-ID');
                        }
                    },
                    // {
                    //     data: "id",
                    //     className: "text-center",
                    //     render: function (data, type, row) {
                    //         return (
                    //             '<a href="' +
                    //             base_url +
                    //             "manage-pemasukan-detail/" +
                    //             data +
                    //             '" class="btn btn-info" title="detail"><i class="fa-solid fa-eye"></i></a>'
                    //         );
                    //     },
                    // },
                ],
                initComplete: function () {
                    $("th").css("text-align", "center");
                    var yearFilter = $("#yearFilter");
                    var currentYear = new Date().getFullYear();
                    for (var year = currentYear; year >= 2000; year--) {
                        yearFilter.append($("<option></option>").val(year).text(year));
                    }
                },
            });

            $("#filterBtn").click(function () {
                var selectedYear = $("#yearFilter").val();
                var selectedMonth = $("#monthFilter").val();
                
                // Custom filtering function
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var date = moment(data[2], 'DD/MM/YYYY');
                        var year = date.year();
                        var month = date.format('MM');
                        
                        if (
                            (selectedYear === "" || year == selectedYear) &&
                            (selectedMonth === "" || month == selectedMonth)
                        ) {
                            return true;
                        }
                        return false;
                    }
                );
                
                table.draw();
                
                // Clear custom filtering function
                $.fn.dataTable.ext.search.pop();
            });
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr.statusText);
        },
    });
}
// Add this after the filter button
'<button class="btn btn-success" id="pdfBtn">Generate PDF</button>'

// Add this to your get_data function, after the filter button click event
$("#pdfBtn").click(function () {
    var selectedYear = $("#yearFilter").val();
    var selectedMonth = $("#monthFilter").val();
    
    var url = base_url + _controller + "/generate_pdf?year=" + selectedYear + "&month=" + selectedMonth;
    window.open(url, '_blank');
});