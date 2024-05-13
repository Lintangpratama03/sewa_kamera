<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_transaksi extends CI_Controller
{
    var $module_js = ['manage-transaksi'];
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
        $this->load->view('front_page/manage_transaksi');
        $this->load->view('template-mitra/footer');
        $this->load->view('template-mitra/end');
        $this->load->view('js-custom', $this->app_data);
    }
    public function get_data()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $query = "SELECT DATE(a.tgl_booking) AS tgl_booking_date, a.*, c.name 
                FROM transaksi a 
                JOIN st_user c ON c.id = a.id_user 
                WHERE a.is_deleted = 0 
                AND (a.status = 'booking' OR a.status = 'terverifikasi' OR a.status = 'bayar' OR a.status = 'lunas') 
                AND a.id_mitra = " . $data['user']['id'];
        $result = $this->db->query($query)->result();
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

    public function get_detail_bayar()
    {
        $id = $this->input->post('id');
        $query_detail_bayar = [
            'select' => 'a.status_bayar, a.va_number, a.tanggal_expire',
            'from' => 'transaksi a',
            'where' => [
                'a.is_deleted' => 0,
                'a.id' => $id,
            ]
        ];
        $result = $this->data->get($query_detail_bayar)->result();
        echo json_encode($result);
    }

    public function terima_data()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id = $this->input->post('id');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $data = array(
            'status' => 'terverifikasi',
            'tgl_verifikasi' => $timestamp,
        );
        $where = array('id' => $id);

        $updated = $this->data->update('transaksi', $where, $data);
        if ($updated) {
            $response['success'] = "<script>$(document).ready(function () {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                  });

                Toast.fire({
                    icon: 'success',
                    title: 'Anda telah melakukan aksi edit data Data berhasil diedit'
                  })
              });</script>";
        }
        echo json_encode($response);
    }

    public function tolak_data()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id = $this->input->post('id');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $data = array(
            'is_deleted' => '1',
        );
        $where = array('id' => $id);

        $updated = $this->data->update('transaksi', $where, $data);
        if ($updated) {
            $response['success'] = "<script>$(document).ready(function () {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                  });

                Toast.fire({
                    icon: 'success',
                    title: 'Anda telah melakukan aksi edit data Data berhasil diedit'
                  })
              });</script>";
        }
        echo json_encode($response);
    }

    public function ambil_data()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id = $this->input->post('id');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $data = array(
            'status' => 'dipinjam',
            'tgl_terima' => $timestamp,
        );
        $where = array('id' => $id);

        $updated = $this->data->update('transaksi', $where, $data);
        if ($updated) {
            $response['success'] = "<script>$(document).ready(function () {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                  });

                Toast.fire({
                    icon: 'success',
                    title: 'Anda telah melakukan aksi edit data Data berhasil diedit'
                  })
              });</script>";
        }
        echo json_encode($response);
    }
}
