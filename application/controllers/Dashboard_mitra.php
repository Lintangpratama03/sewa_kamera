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
		$this->app_data['produk_ready'] = $this->data->count_wheree('product', 'is_deleted', '0', 'id_mitra', $id);
		$this->app_data['produk_pinjam'] = $this->data->count_wheree('product', 'is_deleted', '0', 'id_mitra', $id);
		$this->app_data['total_produk'] = $this->data->count_wheree('product', 'is_deleted', '0', 'id_mitra', $id);
		$this->app_data['jumlah_kategori'] = $this->data->count_wheree('product_has_category', 'is_deleted', '0', 'id_mitra', $id);

		$this->load->view('template-mitra/start', $this->app_data);
		$this->load->view('template-mitra/header', $this->app_data);
		$this->load->view('front_page/dashboard', $this->app_data);
		$this->load->view('template-mitra/footer');
		$this->load->view('template-mitra/end');
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
				'a.id_credential' => '1'
			]
		];
		$result = $this->data->get($query)->result();
		echo json_encode($result);
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
}
