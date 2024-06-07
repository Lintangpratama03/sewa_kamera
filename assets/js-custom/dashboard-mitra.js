/* global Chart:false */

$(function () {
	'use strict'
	var ticksStyle = {
	  fontColor: '#495057',
	  fontStyle: 'bold'
	}
  
	var mode = 'index'
	var intersect = true
  
	var $visitorsChart = $('#visitors-chart');
  
	var visitorsChart = new Chart($visitorsChart, {
	  data: {
		labels: visitorsChartLabels,
		datasets: [{
		  type: 'bar', // Menentukan tipe dataset sebagai 'bar'
		  data: visitorsChartData,
		  backgroundColor: '#007bff', // Menggunakan warna solid untuk batang
		  borderWidth: 1, // Lebar garis tepi batang (opsional)
		}]
	  },
	  options: {
		maintainAspectRatio: false,
		tooltips: {
		  mode: mode,
		  intersect: intersect
		},
		hover: {
		  mode: mode,
		  intersect: intersect
		},
		legend: {
		  display: false
		},
		scales: {
		  yAxes: [{
			gridLines: {
			  display: true,
			  lineWidth: '4px',
			  color: 'rgba(0, 0, 0, .2)',
			  zeroLineColor: 'transparent'
			},
			ticks: $.extend({
			  beginAtZero: true,
			  suggestedMax: suggestedMax // Menggunakan nilai maksimum yang diusulkan
			}, ticksStyle)
		  }],
		  xAxes: [{
			display: true,
			gridLines: {
			  display: false
			},
			ticks: ticksStyle,
			barPercentage: 0.6, // Lebar batang (antara 0 dan 1)
			categoryPercentage: 0.8 // Jarak antar batang (antara 0 dan 1)
		  }]
		}
	  }
	});
	var $salesChart = $('#salesChart');

    var salesChart = new Chart($salesChart, {
        data: {
            labels: salesChartLabels,
            datasets: [{
                type: 'line',
                data: salesChartData,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                pointBorderColor: '#007bff',
                pointBackgroundColor: '#007bff',
                fill: false
            }]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        beginAtZero: true,
                        suggestedMax: suggestedMax // Menggunakan nilai maksimum yang diusulkan
                    }, ticksStyle)
                }],
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    },
                    ticks: ticksStyle
                }]
            }
        }
    });
  })

get_data();
function get_data() {
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
					{ data: "nama_produk" ,
					className: "text-center"},
					{ data: "name" ,
					className: "text-center"},
					{ data: "total_dipinjam" ,
					className: "text-center"},
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
