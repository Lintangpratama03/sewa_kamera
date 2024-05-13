<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_history_kembali_detail extends CI_Controller
{
    var $module_js = ['manage-history-kembali-detail'];
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
        //$this->app_data['selectVariant'] = $this->data->find('paket', $where)->result();

        $this->app_data['select'] = $this->data->find('category', $where)->result();


        $this->load->view('template-mitra/start', $this->app_data);
        $this->load->view('template-mitra/header', $this->app_data);
        $this->load->view('front_page/manage_history_kembali_detail');
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

    public function get_data_denda($id)
    {
        $query = [
            'select' => 'c.telat,c.ganti_rugi,c.total, a.*',
            'from' => 'transaksi a',
            'leftjoin' => [
                'detail_denda c, a.id = c.id_transaksi'
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
                'category e, e.id = b.id_category',
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
    // KONFIRMASI
    public function update_product()
    {
        $id_d_array = $this->input->post('id_d_array');

        if (is_array($id_d_array) && !empty($id_d_array)) {
            foreach ($id_d_array as $id_d) {
                // Get the product details based on the id_d
                $query = [
                    'select' => 'b.id, b.stok, d.jumlah, d.id_produk',
                    'from' => 'detail_transaksi d',
                    'join' => [
                        'product b, b.id = d.id_produk'
                    ],
                    'where' => [
                        'd.id' => $id_d
                    ]
                ];
                $result = $this->data->get($query)->row();

                if ($result) {
                    // Update the product stock
                    $data = array(
                        'stok' => $result->stok + $result->jumlah
                    );
                    $where = array('id' => $result->id_produk);
                    $updated = $this->data->update('product', $where, $data);

                    if (!$updated) {
                        $response['success'] = false;
                        echo json_encode($response);
                        return;
                    }
                } else {
                    $response['success'] = false;
                    echo json_encode($response);
                    return;
                }
            }

            $response['success'] = true;
            echo json_encode($response);
        } else {
            $response['success'] = false;
            echo json_encode($response);
        }
    }

    public function update_denda()
    {
        $id_transaksi = $this->input->post('id_transaksi');
        $telat = $this->input->post('telat');
        $denda = $this->input->post('denda');
        $total = $this->input->post('total');
        $where = array('id_transaksi' => $id_transaksi);
        $denda_record = $this->data->find('detail_denda', $where)->row_array();


        $data = array(
            'telat' => $telat,
            'ganti_rugi' => $denda,
            'total' => $total
        );

        if ($denda_record) {
            $updated = $this->data->update('detail_denda', $where, $data);
            if ($updated) {
                $response['success'] = true;
                $data1 = array(
                    'status' => 5
                );
                $where1 = array('id' => $id_transaksi);
                $this->data->update('transaksi', $where1, $data1);
            } else {
                $response['success'] = false;
            }
        } else {
            $data['id_transaksi'] = $id_transaksi;
            $inserted = $this->data->insert('detail_denda', $data);
            if ($inserted) {
                $response['success'] = true;
                $data1 = array(
                    'status' => 5
                );
                $where1 = array('id' => $id_transaksi);
                $this->data->update('transaksi', $where1, $data1);
            } else {
                $response['success'] = false;
            }
        }


        echo json_encode($response);
    }

    public function get_id_d()
    {
        $id_transaksi = $this->input->post('id_transaksi');

        $query = [
            'select' => 'd.id as id_d',
            'from' => 'detail_transaksi d',
            'where' => [
                'd.status' => '1',
                'd.id_transaksi' => $id_transaksi
            ]
        ];

        $result = $this->data->get($query)->result_array();

        if ($result) {
            $id_d_array = array_column($result, 'id_d');
            $response['success'] = true;
            $response['id_d_array'] = $id_d_array;
        } else {
            $response['success'] = false;
            $response['id_d_array'] = [];
        }

        echo json_encode($response);
    }
}
