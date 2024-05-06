/* global Chart:false */

$(function () {
	'use strict'
	var ticksStyle = {
		fontColor: '#495057',
		fontStyle: 'bold'
	}

	var mode = 'index'
	var intersect = true

	var $salesChart = $('#sales-chart')
	// eslint-disable-next-line no-unused-vars
	var salesChart = new Chart($salesChart, {
		type: 'bar',
		data: {
			labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
			datasets: [
				{
					backgroundColor: '#007bff',
					borderColor: '#007bff',
					data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
				},
				{
					backgroundColor: '#ced4da',
					borderColor: '#ced4da',
					data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
				}
			]
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
					// display: false,
					gridLines: {
						display: true,
						lineWidth: '4px',
						color: 'rgba(0, 0, 0, .2)',
						zeroLineColor: 'transparent'
					},
					ticks: $.extend({
						beginAtZero: true,

						// Include a dollar sign in the ticks
						callback: function (value) {
							if (value >= 1000) {
								value /= 1000
								value += 'k'
							}

							return '$' + value
						}
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
	})

	var $visitorsChart = $('#visitors-chart');
 // Menghitung nilai maksimum yang diusulkan (kelipatan 5 terdekat ditambah 5)

	var visitorsChart = new Chart($visitorsChart, {
		data: {
			labels: visitorsChartLabels,
			datasets: [{
				type: 'line',
				data: visitorsChartData,
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




//   chart pelaporan
var salesChartCanvas = $('#salesChart').get(0).getContext('2d')

var salesChartData = {
	labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
	datasets: [
		{
			label: 'Digital Goods',
			backgroundColor: 'rgba(60,141,188,0.9)',
			borderColor: 'rgba(60,141,188,0.8)',
			pointRadius: false,
			pointColor: '#3b8bba',
			pointStrokeColor: 'rgba(60,141,188,1)',
			pointHighlightFill: '#fff',
			pointHighlightStroke: 'rgba(60,141,188,1)',
			data: [28, 48, 40, 19, 86, 27, 90]
		},
		{
			label: 'Electronics',
			backgroundColor: 'rgba(210, 214, 222, 1)',
			borderColor: 'rgba(210, 214, 222, 1)',
			pointRadius: false,
			pointColor: 'rgba(210, 214, 222, 1)',
			pointStrokeColor: '#c1c7d1',
			pointHighlightFill: '#fff',
			pointHighlightStroke: 'rgba(220,220,220,1)',
			data: [65, 59, 80, 81, 56, 55, 40]
		}
	]
}

var salesChartOptions = {
	maintainAspectRatio: false,
	responsive: true,
	legend: {
		display: false
	},
	scales: {
		xAxes: [{
			gridLines: {
				display: false
			}
		}],
		yAxes: [{
			gridLines: {
				display: false
			}
		}]
	}
}

// This will get the first returned node in the jQuery collection.
// eslint-disable-next-line no-unused-vars
var salesChart = new Chart(salesChartCanvas, {
	type: 'line',
	data: salesChartData,
	options: salesChartOptions
}
)
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
