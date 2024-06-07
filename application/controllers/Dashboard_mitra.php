<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_mitra extends CI_Controller
{

	var $module_js = ['dashboard-mitra'];
	var $app_data = [];

	public function __construct()
	{
		parent::__construct();
		$this->_init();
		if (!$this->is_logged_in()) {
			redirect('dashboard');
		}
	}

	public function is_logged_in()
	{
		return $this->session->userdata('logged_in_1') === TRUE;
	}

	private function _init()
	{
		$this->app_data['module_js'] = $this->module_js;
	}

	public function index()
	{
		$query_menu = [
			'select' => 'id_parent,name, icon, link, type, is_admin',
			'from' => 'app_menu',
			'where' => [
				'is_admin' => '2'
			]
		];

		$query_dropdown = [
			'select' => 'id_parent,name,link,icon, type, is_admin',
			'from' => 'app_menu',
			'where' => [
				'type' => '2',
				'is_admin' => '2'
			]
		];

		$query_child = [
			'select' => 'id_parent,name,link,icon, type, is_admin',
			'from' => 'app_menu',
			'where' => [
				'type' => '3',
				'is_admin' => '2'
			]
		];

		$user = [
			'select' => 'a.id, a.name, a.email, a.image, a.phone_number, a.address, b.name as akses',
			'from' => 'st_user a',
			'join' => [
				'app_credential b, b.id = a.id_credential'
			],
			'where' => [
				'a.is_deleted' => '0',
				'a.email' => $this->session->userdata('email')
			]
		];
		$this->app_data['get_menu'] = $this->data->get($query_menu)->result();
		$this->app_data['get_dropdown'] = $this->data->get($query_dropdown)->result();
		$this->app_data['get_child'] = $this->data->get($query_child)->result();
		$this->app_data['user'] = $this->data->get($user)->row_array();
		$this->app_data['title'] = 'Dashboard';



		$where = array('email' => $this->session->userdata('email'));
		$data['user'] = $this->data->find('st_user', $where)->row_array();
		$id = $data['user']['id'];

		// menhitung produk yang tersedia
		$produk_ready_query = "SELECT SUM(stok) AS total_stok
								FROM product
								WHERE is_deleted = '0'
								AND id_mitra = $id";
		$produk_ready_result = $this->db->query($produk_ready_query, array($id))->row();
		$this->app_data['produk_ready'] = $produk_ready_result->total_stok;


		$produk_pinjam_query = "SELECT SUM(detail_transaksi.jumlah) AS total_stok
								FROM detail_transaksi
								LEFT JOIN product ON detail_transaksi.id_produk = product.id
								WHERE detail_transaksi.STATUS = '0'		
								AND product.id_mitra = $id";
		$produk_pinjam_result = $this->db->query($produk_pinjam_query, array($id))->row();
		$this->app_data['produk_pinjam'] = $produk_pinjam_result->total_stok;

		$this->app_data['total_produk'] = $this->data->count_wheree('product', 'is_deleted', '0', 'id_mitra', $id);

		$produk_hilang = "SELECT SUM(detail_transaksi.jumlah) AS total_stok
								FROM detail_transaksi
								LEFT JOIN product ON detail_transaksi.id_produk = product.id
								WHERE detail_transaksi.STATUS = '2'		
								AND product.id_mitra = $id";
		$produk_hilang_result = $this->db->query($produk_hilang, array($id))->row();
		$this->app_data['produk_hilang'] = $produk_hilang_result->total_stok;

		$tahun = date('Y');
		$jumlah_sewa_perbulan = "SELECT COUNT(transaksi.id) AS jumlah
								FROM transaksi
								WHERE (status = 'selesai' OR status = 'dipinjam' OR status = 'lunas')
								AND id_mitra = $id
								AND YEAR(tgl_transaksi) = $tahun";
		$jumlah_sewa_perbulan_result = $this->db->query($jumlah_sewa_perbulan, array($id))->row();
		$this->app_data['jumlah_sewa'] = $jumlah_sewa_perbulan_result->jumlah;


		$pendapatan_bulan_kemarin = "SELECT FORMAT(SUM(total_harga), 0) AS total_bulan_kemarin
								FROM transaksi
								WHERE MONTH(tgl_transaksi) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
								AND YEAR(tgl_transaksi) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
								AND transaksi.id_mitra = $id";
		$pendapatan_bulan_kemarin_result = $this->db->query($pendapatan_bulan_kemarin, array($id))->row();
		$this->app_data['pendapatan_bulan_kemarin'] = $pendapatan_bulan_kemarin_result->total_bulan_kemarin;

		$pendapatan_bulan_ini = "SELECT FORMAT(SUM(total_harga), 0) AS total_bulan_ini
								FROM transaksi
								WHERE MONTH(tgl_transaksi) = MONTH(CURRENT_DATE())
								AND YEAR(tgl_transaksi) = YEAR(CURRENT_DATE())
								AND transaksi.id_mitra = $id";
		$pendapatan_bulan_ini_result = $this->db->query($pendapatan_bulan_ini, array($id))->row();
		$this->app_data['pendapatan_bulan_ini'] = $pendapatan_bulan_ini_result->total_bulan_ini;

		$pendapatan_tahun_ini = "SELECT FORMAT(SUM(total_harga), 0) AS total_tahun_ini
								FROM transaksi
								WHERE YEAR(tgl_transaksi) = YEAR(CURRENT_DATE())
								AND transaksi.id_mitra = $id";
		$pendapatan_tahun_ini_result = $this->db->query($pendapatan_tahun_ini, array($id))->row();
		$this->app_data['pendapatan_tahun_ini'] = $pendapatan_tahun_ini_result->total_tahun_ini;

		$pendapatan_all = "SELECT FORMAT(SUM(total_harga), 0) AS total_all
								FROM transaksi
								WHERE transaksi.id_mitra = $id";
		$pendapatan_all_result = $this->db->query($pendapatan_all, array($id))->row();
		$this->app_data['pendapatan_all'] = $pendapatan_all_result->total_all;


		$data_chart = $this->chart_sewa_bulanan($id, $tahun);
		$this->app_data['chartData'] = $data_chart;

		$pendapatan_chart = $this->chart_pendapatan_bulanan($id, $tahun);
		$this->app_data['chartPendapatan'] = $pendapatan_chart;

		$this->load->view('template-mitra/start', $this->app_data);
		$this->load->view('template-mitra/header', $this->app_data);
		$this->load->view('front_page/dashboard', $this->app_data);
		$this->load->view('template-mitra/footer');
		$this->load->view('template-mitra/end');
		$this->load->view('js-custom', $this->app_data);
	}

	public function get_data_chart()
	{
		$query = [
			'select' => 'a.id, a.name, a.email, a.image, a.phone_number, a.address, a.card_image, a.username, a.password, a.last_login, b.name as akses',
			'from' => 'st_user a',
			'join' => [
				'app_credential b, b.id = a.id_credential'
			],
			'where' => [
				'a.is_deleted' => '0',
				'a.id_credential' => '1'
			]
		];
		$result = $this->data->get($query)->result();
		echo json_encode($result);
	}

	public function chart_sewa_bulanan($id_mitra, $tahun)
	{
		if (!$id_mitra) {
			$where = array('email' => $this->session->userdata('email'));
			$data['user'] = $this->data->find('st_user', $where)->row_array();
			$id_mitra = $data['user']['id'];
		}
		$query = $this->db->query("
				SELECT 
				YEAR(tgl_transaksi) AS tahun,
				MONTH(tgl_transaksi) AS bulan,
				COUNT(id) AS jumlah_transaksi_per_bulan
			FROM transaksi
			WHERE (status = 'selesai' OR status = 'dipinjam' OR status = 'lunas')
			AND id_mitra = $id_mitra
			AND YEAR(tgl_transaksi) = $tahun
			GROUP BY YEAR(tgl_transaksi), MONTH(tgl_transaksi)
			ORDER BY MONTH(tgl_transaksi);
			");

		$result = $query->result();

		$data = [];
		foreach ($result as $value) {
			$monthName = $this->getMonth($value->bulan);
			$data[$monthName] = $value->jumlah_transaksi_per_bulan;
		}

		return $data;
	}
	public function chart_pendapatan_bulanan($id_mitra, $tahun)
	{
		if (!$id_mitra) {
			$where = array('email' => $this->session->userdata('email'));
			$data['user'] = $this->data->find('st_user', $where)->row_array();
			$id_mitra = $data['user']['id'];
		}
		$query = $this->db->query("
				SELECT 
				YEAR(tgl_transaksi) AS tahun,
				MONTH(tgl_transaksi) AS bulan,
				sum(total_harga) AS jumlah_transaksi_per_bulan
			FROM transaksi
			WHERE (status = 'selesai' OR status = 'dipinjam' OR status = 'lunas')
			AND id_mitra = $id_mitra
			AND YEAR(tgl_transaksi) = $tahun
			GROUP BY YEAR(tgl_transaksi), MONTH(tgl_transaksi)
			ORDER BY MONTH(tgl_transaksi);
			");

		$result = $query->result();

		$data = [];
		foreach ($result as $value) {
			$monthName = $this->getMonth($value->bulan);
			$data[$monthName] = $value->jumlah_transaksi_per_bulan;
		}

		return $data;
	}

	public function get_chart_data($id_mitra, $tahun)
	{
		$result = $this->chart_sewa_bulanan($id_mitra, $tahun);
		echo json_encode($result);
	}

	public function get_chart_pendapatan($id_mitra, $tahun)
	{
		$result = $this->chart_pendapatan_bulanan($id_mitra, $tahun);
		echo json_encode($result);
	}

	private function getMonth($monthNum)
	{
		$dateObj   = DateTime::createFromFormat('!m', $monthNum);
		return $dateObj->format('F');
	}

	public function get_data()
	{
		$where = array('email' => $this->session->userdata('email'));
		$data['user'] = $this->data->find('st_user', $where)->row_array();
		$query = [
			'select' => 'p.id, p.nama_produk, k.name, SUM(dt.jumlah) AS total_dipinjam',
			'from' => 'product p',
			'join' => [
				'detail_transaksi dt, p.id = dt.id_produk',
				'category k, p.id_category = k.id'
			],
			'where' => [
				'p.is_deleted' => 0,
				'p.id_mitra' => $data['user']['id'],
			],
			'group_by' => 'p.id, p.nama_produk',
			'order_by' => 'total_dipinjam DESC',
			'limit' => 5
		];
		$result = $this->data->get($query)->result();
		echo json_encode($result);
	}
}
