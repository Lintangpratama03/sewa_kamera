<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_admin extends CI_Controller
{

	var $module_js = ['dashboard'];
	var $app_data = [];

	public function __construct()
	{
		parent::__construct();
		$this->_init();
		if (!$this->is_logged_in()) {
			redirect('dashboard-mitra');
		}
	}

	public function is_logged_in()
	{
		return $this->session->userdata('logged_in') === TRUE;
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
				'is_admin' => '1'
			]
		];

		$query_dropdown = [
			'select' => 'id_parent,name,link,icon, type, is_admin',
			'from' => 'app_menu',
			'where' => [
				'type' => '2',
				'is_admin' => '1'
			]
		];

		$query_child = [
			'select' => 'id_parent,name,link,icon, type, is_admin',
			'from' => 'app_menu',
			'where' => [
				'type' => '3',
				'is_admin' => '1'
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

		$this->app_data['pelanggan_daftar'] = $this->data->count_wheree('st_user', 'is_aktif', '0', 'id_credential', '3');
		$this->app_data['pelanggan_aktif'] = $this->data->count_wheree('st_user', 'is_aktif', '1', 'id_credential', '3');
		$this->app_data['mitra_daftar'] = $this->data->count_wheree('st_user', 'is_aktif', '0', 'id_credential', '2');
		$this->app_data['mitra_aktif'] = $this->data->count_wheree('st_user', 'is_aktif', '1', 'id_credential', '2');

		$this->load->view('template-admin/start', $this->app_data);
		$this->load->view('template-admin/header', $this->app_data);
		$this->load->view('menu-admin/dashboard', $this->app_data);
		$this->load->view('template-admin/footer');
		$this->load->view('template-admin/end');
		$this->load->view('js-custom', $this->app_data);
	}

	public function get_data()
	{
		$query = [
			'select' => 'a.id, a.name, a.email, a.image, a.phone_number, a.address, a.card_image, a.username, a.password, a.last_login, b.name as akses',
			'from' => 'st_user a',
			'join' => [
				'app_credential b, b.id = a.id_credential'
			],
			'where' => [
				'a.is_deleted' => '0',
				'a.id_credential' => '3'
			]
		];
		$result = $this->data->get($query)->result();
		echo json_encode($result);
	}
	public function get_chart_data()
	{
		// Query untuk mendapatkan 5 mitra terpopuler
		$mitra_query = [
			'select' => 'st_user.name, COUNT(transaksi.id) as jumlah_transaksi',
			'from' => 'st_user',
			'join' => [
				'transaksi, transaksi.id_mitra = st_user.id'
			],
			'where' => [
				'st_user.id_credential' => '2',
				'st_user.is_deleted' => '0'
			],
			'group_by' => 'st_user.id',
			'order_by' => 'jumlah_transaksi DESC',
			'limit' => 5
		];
		$mitra_data = $this->data->get($mitra_query)->result();

		// Query untuk mendapatkan 5 produk terpopuler
		$produk_query = [
			'select' => 'product.nama_produk, COUNT(detail_transaksi.id) as jumlah_peminjaman',
			'from' => 'product',
			'join' => [
				'detail_transaksi, detail_transaksi.id_produk = product.id'
			],
			'where' => [
				'product.is_deleted' => '0'
			],
			'group_by' => 'product.id',
			'order_by' => 'jumlah_peminjaman DESC',
			'limit' => 5
		];
		$produk_data = $this->data->get($produk_query)->result();

		$data = [
			'mitra' => $mitra_data,
			'produk' => $produk_data
		];

		echo json_encode($data);
	}
}
