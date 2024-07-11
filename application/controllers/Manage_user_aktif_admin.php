<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_user_aktif_admin extends CI_Controller
{
    var $module_js = ['manage-user-aktif-admin'];
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
            'select' => 'a.id, a.name, a.email, a.image, a.phone_number, a.address, a.id_credential, b.name as akses',
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
        $this->app_data['title'] = 'Kelola user';
        $this->load->view('template-admin/start', $this->app_data);
        $this->load->view('template-admin/header', $this->app_data);
        $this->load->view('menu-admin/manage_user_aktif');
        $this->load->view('template-admin/footer');
        $this->load->view('template-admin/end');
        $this->load->view('js-custom', $this->app_data);
    }

    public function get_data()
    {
        $query = [
            'select' => 'a.id, a.name, a.email, a.image, a.phone_number, a.address, a.ktp_image as ktp, a.username, a.password, a.last_login, b.name as akses',
            'from' => 'st_user a',
            'join' => [
                'app_credential b, b.id = a.id_credential'
            ],
            'where' => [
                'a.is_deleted' => '0',
                'a.is_aktif' => '1',
                'id_credential' => '3'
            ]
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function get_data_id()
    {
        $id = $this->input->post('id');
        $query = [
            'select' => 'a.id, a.name, a.email, a.image, a.phone_number, a.address, a.ktp_image as ktp, a.username, a.password, a.last_login, a.id_credential',
            'from' => 'st_user a',
            'where' => [
                'a.is_deleted' => '0',
                'a.id' => $id
            ]
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function insert_data()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('telepon', 'No HP', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[st_user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]');
        $this->form_validation->set_rules('password1', 'Ulangi', 'required|trim|matches[password]');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
            if (empty($_FILES['card']['name'])) {
                $response['errors']['card'] = "Foto KTP harus diupload";
            }
            if (empty($_FILES['image']['name'])) {
                $response['errors']['image'] = "Foto profil harus diupload";
            }
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();

            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $telepon = $this->input->post('telepon');
            $alamat = $this->input->post('alamat');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $hash = hash("sha256", $password . config_item('encryption_key'));
            if (empty($_FILES['card']['name'])) {
                $response['errors']['card'] = "Foto KTP harus diupload";
            }
            if (empty($_FILES['image']['name'])) {
                $response['errors']['image'] = "Foto profil harus diupload";
            } else {
                $data = array(
                    'name' => $nama,
                    'email' => $email,
                    'phone_number' => $telepon,
                    'address' => $alamat,
                    'id_credential' => 3,
                    'username' => $username,
                    'password' => $hash,
                    'is_aktif' => 1,
                    'created_by' => $data['user']['id'],
                );

                if (!empty($_FILES['image']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/user/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['file_name'] = $username . "-" . $currentDateTime;
                    $config['max_size'] = 2048;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {
                        $response['errors']['image'] = strip_tags($this->upload->display_errors());
                        echo json_encode($response);
                        return;
                    } else {
                        $uploaded_data = $this->upload->data();
                        $data['image'] = $uploaded_data['file_name'];

                        if (!empty($_FILES['card']['name'])) {
                            $currentDateTime = date('Y-m-d_H-i-s');
                            $config['upload_path'] = './assets/image/user/';
                            $config['allowed_types'] = 'gif|jpg|jpeg|png';
                            $config['file_name'] = $username . "-" . $currentDateTime;
                            $config['max_size'] = 2048;

                            $this->load->library('upload', $config);

                            if ($this->upload->do_upload('card')) {
                                $uploaded_data = $this->upload->data();
                                $data['ktp'] = $uploaded_data['file_name'];
                            } else {
                                $response['errors']['card'] = strip_tags($this->upload->display_errors());
                            }
                        }
                        $this->data->insert('st_user', $data);
                    }
                }
                $response['success'] = "<script>$(document).ready(function () {
                        var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                          });

                        Toast.fire({
                            icon: 'success',
                            title: 'Anda telah melakukan aksi tambah data Data berhasil dimasukkan'
                          })
                      });</script>";
            }
        }
        echo json_encode($response);
    }

    public function edit_data()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('telepon', 'No HP', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password1', 'Password Lama', 'trim|min_length[8]');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
            if (empty($_FILES['image']['name'])) {
                $response['errors']['image'] = "Foto profil harus diupload";
            }
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();

            $id = $this->input->post('id');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $telepon = $this->input->post('telepon');
            $alamat = $this->input->post('alamat');
            $username = $this->input->post('username');
            $password = $this->input->post('password1');
            $hash = hash("sha256", $password . config_item('encryption_key'));
            $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

            $data = array(
                'name' => $nama,
                'email' => $email,
                'phone_number' => $telepon,
                'address' => $alamat,
                'username' => $username,
                'updated_date' => $timestamp,
                'updated_by' => $data['user']['id'],
            );

            if (!empty($password)) {
                $data['password'] = $hash;
            }

            $where = array('id' => $id);
            $updated = $this->data->update('st_user', $where, $data);

            if (!$updated) {
                $response['errors']['database'] = "Failed to update data in the database.";
            } else {
                if (!empty($_FILES['image']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/user/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = $username . "-" . $currentDateTime;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();
                        $profile = $upload_data['file_name'];

                        $data = array('image' => $profile);
                        $where = array('id' => $id);
                        $this->data->update('st_user', $where, $data);
                    } else {
                        $response['errors']['image'] = strip_tags($this->upload->display_errors());
                    }
                }
                if (!empty($_FILES['card']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/user/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = $username . "-" . $currentDateTime;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('card')) {
                        $upload_data = $this->upload->data();
                        $ktp = $upload_data['file_name'];

                        $data = array('ktp' => $ktp);
                        $where = array('id' => $id);
                        $this->data->update('st_user', $where, $data);
                    } else {
                        $response['errors']['card'] = strip_tags($this->upload->display_errors());
                    }
                }
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
        }
        echo json_encode($response);
    }

    public function delete_data()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id = $this->input->post('id');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $data = array(
            'is_deleted' => '1',
            'deleted_date' => $timestamp,
            'deleted_by' => $data['user']['id'],
        );
        $where = array('id' => $id);

        $updated = $this->data->update('st_user', $where, $data);
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
