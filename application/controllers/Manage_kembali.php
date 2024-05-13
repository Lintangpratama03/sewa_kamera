<?php
defined('BASEPATH') or exit('No direct script access allowed');

class manage_kembali extends CI_Controller
{
    var $module_js = ['manage-kembali'];
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
        $this->app_data['title'] = 'Kelola transaksi';
        $this->load->view('template-mitra/start', $this->app_data);
        $this->load->view('template-mitra/header', $this->app_data);
        $this->load->view('front_page/manage_kembali');
        $this->load->view('template-mitra/footer');
        $this->load->view('template-mitra/end');
        $this->load->view('js-custom', $this->app_data);
    }
    public function get_data()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $query = [
            'select' => 'DATE(a.tgl_booking) as tgl_booking_date,DATE(a.tgl_tenggat) as tgl_tenggat_date, a.*, c.name',
            'from' => 'transaksi a',
            'join' => [
                'st_user c, c.id = a.id_user',
            ],
            'where' => [
                'a.is_deleted' => 0,
                'a.status' => 'dipinjam',
                'a.id_mitra' => $data['user']['id'],
            ]
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function get_data_id()
    {
        $id = $this->input->post('id');
        $query = [
            'select' => 'DATE(a.tgl_booking) as tgl_booking_date, a.*, b.nama_produk, c.name, c.image, b.image as image_produk',
            'from' => 'transaksi a',
            'join' => [
                'st_user c, c.id = a.id_user',
                'detail_transaksi d, d.id_transaksi = a.id',
                'product b, b.id = d.id_produk',

            ],
            'where' => [
                'a.is_deleted' => 0,
                'a.id' => $id,
            ]
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }
}
