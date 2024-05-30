<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_pemasukan_detail extends CI_Controller
{
    var $module_js = ['manage-pemasukan-detail'];
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

    public function index($tahun, $bulan)
    {
        $this->app_data['tahun'] = $tahun;
        $this->app_data['bulan'] = $bulan;
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Validasi untuk memastikan bahwa $bulan adalah angka antara 1 dan 12
        if ($bulan < 1 || $bulan > 12) {
            return "Bulan tidak valid.";
        }

        // Mendapatkan nama bulan
        $this->app_data['bulan_text'] = $namaBulan[$bulan];

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
        $this->app_data['title'] = 'Kelola pemasukan';
        $this->load->view('template-mitra/start', $this->app_data);
        $this->load->view('template-mitra/header', $this->app_data);
        $this->load->view('front_page/manage_pemasukan_detail');
        $this->load->view('template-mitra/footer');
        $this->load->view('template-mitra/end');
        $this->load->view('js-custom', $this->app_data);
    }
    public function get_data($tahun, $bulan)
    {
        // Get user data from session
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id_mitra = $data['user']['id'];

        // Prepare the SQL query
        $query = "SELECT 
            YEAR(t.tgl_transaksi) AS tahun,
            MONTH(t.tgl_transaksi) AS bulan,
            t.tgl_transaksi AS tgl_transaksi,
            u.name AS nama_pelanggan,
            t.id_mitra,
            SUM(t.total_harga) AS total_transaksi,
            SUM(IFNULL(d.total, 0)) AS total_denda,
            SUM(t.total_harga + IFNULL(d.total, 0)) AS total_pemasukan
        FROM 
            transaksi t
        LEFT JOIN
            detail_denda d ON t.id = d.id_transaksi
        LEFT JOIN
            st_user u ON t.id_user = u.id
        WHERE 
            t.status = 'selesai'
            AND t.is_deleted = 0
            AND t.id_mitra = ?
            AND YEAR(t.tgl_transaksi) = ?
            AND MONTH(t.tgl_transaksi) = ?
        GROUP BY 
            tahun, bulan, t.id_mitra, t.id_user, u.name, t.tgl_transaksi
        ORDER BY 
            tahun, bulan, t.id_mitra;
        ";


        // Execute the query with parameters for id_mitra, tahun, and bulan
        $result = $this->db->query($query, array($id_mitra, $tahun, $bulan))->result();

        // Output the result in JSON format
        echo json_encode($result);
    }
}
