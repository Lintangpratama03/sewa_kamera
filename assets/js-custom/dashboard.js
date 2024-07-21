get_data();
// Data untuk grafik mitra populer
var mitraData = {
	labels: ['Mitra A', 'Mitra B', 'Mitra C', 'Mitra D', 'Mitra E'],
	datasets: [{
	  label: 'Jumlah Transaksi',
	  data: [120, 90, 80, 70, 60],
	  backgroundColor: 'rgba(75, 192, 192, 0.6)',
	  borderColor: 'rgba(75, 192, 192, 1)',
	  borderWidth: 1
	}]
  };
  
  // Data untuk grafik produk terpopuler
  var produkData = {
	labels: ['Produk X', 'Produk Y', 'Produk Z', 'Produk W', 'Produk V'],
	datasets: [{
	  label: 'Jumlah Peminjaman',
	  data: [50, 40, 30, 20, 10],
	  backgroundColor: 'rgba(255, 99, 132, 0.6)',
	  borderColor: 'rgba(255, 99, 132, 1)',
	  borderWidth: 1
	}]
  };
  
  // Konfigurasi untuk kedua grafik
  var options = {
	scales: {
	  y: {
		beginAtZero: true
	  }
	}
  };
  
  // Membuat grafik mitra populer
  var mitraCtx = document.getElementById('mitraChart').getContext('2d');
  var mitraChart = new Chart(mitraCtx, {
	type: 'bar',
	data: mitraData,
	options: options
  });
  
  // Membuat grafik produk terpopuler
  var produkCtx = document.getElementById('produkChart').getContext('2d');
  var produkChart = new Chart(produkCtx, {
	type: 'bar',
	data: produkData,
	options: options
  });
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
					{ data: "name" },
					{ data: "phone_number" },
					{ data: "address" },
					{
						data: "image",
						className: "text-center",
						render: function (data, type, row) {
							var imageUrl = base_url + "assets/image/user/" + data;
							return (
								'<img src="' +
								imageUrl +
								'" style="max-width: 100px; max-height: 400px;">'
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
	$.ajax({
		url: base_url + 'dashboard_admin/get_chart_data',
		method: 'GET',
		dataType: 'json',
		success: function(response) {
			var mitraLabels = response.mitra.map(item => item.name);
			var mitraValues = response.mitra.map(item => item.jumlah_transaksi);
			
			var produkLabels = response.produk.map(item => item.nama_produk);
			var produkValues = response.produk.map(item => item.jumlah_peminjaman);
	
			// Update data grafik mitra
			mitraChart.data.labels = mitraLabels;
			mitraChart.data.datasets[0].data = mitraValues;
			mitraChart.update();
	
			// Update data grafik produk
			produkChart.data.labels = produkLabels;
			produkChart.data.datasets[0].data = produkValues;
			produkChart.update();
		},
		error: function(xhr, status, error) {
			console.error('Error fetching chart data:', error);
		}
	});
}
