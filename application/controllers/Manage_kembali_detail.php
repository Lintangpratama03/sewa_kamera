<?php
defined('BASEPATH') or exit('No direct script access allowed');

class manage_kembali_detail extends CI_Controller
{
    var $module_js = ['manage-kembali-detail'];
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

    public function index($id)
    {
        // echo "Contents of id: " . $id;
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
        $this->app_data['id'] = $id;
        // $this->get_data($id);
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $where = array('is_deleted' => '0');
        $where = array('id_mitra' =>  $data['user']['id']);
        //$this->app_data['selectVariant'] = $this->data->find('paket', $where)->result();

        $this->app_data['select'] = $this->data->find('product_has_category', $where)->result();


        $this->load->view('template-mitra/start', $this->app_data);
        $this->load->view('template-mitra/header', $this->app_data);
        $this->load->view('front_page/manage_kembali_detail');
        $this->load->view('template-mitra/footer');
        $this->load->view('template-mitra/end');
        $this->load->view('js-custom', $this->app_data);
    }

    public function get_data_penyewa($id)
    {
        $query = [
            'select' => 'c.*',
            'from' => 'transaksi a',
            'join' => [
                'st_user c, c.id = a.id_user'
            ],
            'where' => [
                'a.is_deleted' => 0,
                'a.id' => $id,
            ]
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function get_data($id)
    {
        $query = [
            'select' => 'd.id as id_pr,DATE(a.tgl_booking) as tgl_booking_date, a.*, b.nama_produk, c.name, c.image, b.image as image_produk, d.jumlah, d.status as status_pr',
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

    public function get_data_id()
    {
        $id = $this->input->post('id');
        $query = [
            'select' => 'b.*, e.name, d.jumlah as jml, d.id as id_d,d.keterangan as ket_d',
            'from' => 'transaksi a',
            'join' => [
                'st_user c, c.id = a.id_user',
                'detail_transaksi d, d.id_transaksi = a.id',
                'product b, b.id = d.id_produk',
                'product_has_category e, e.id = b.id_category',
            ],
            'where' => [
                'd.id' => $id
            ],
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }


    public function kembali_data()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id_d = $this->input->post('id_d');
        $keterangan = $this->input->post('keterangan');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $data = array(
            'status' => '1',
            'keterangan' => $keterangan
        );
        $where = array('id' => $id_d);

        $updated = $this->data->update('detail_transaksi', $where, $data);
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


    public function tdk_kembali()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id_d = $this->input->post('id_d');
        $keterangan = $this->input->post('keterangan');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $data = array(
            'status' => '2',
            'keterangan' => $keterangan
        );
        $where = array('id' => $id_d);

        $updated = $this->data->update('detail_transaksi', $where, $data);
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
