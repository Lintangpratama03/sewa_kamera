<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_user extends CI_Controller
{
    var $module_js = ['auth_user'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        $this->_init();
    }

    private function _init()
    {
        $this->app_data['module_js'] = $this->module_js;
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('dashboard-mitra');
        }

        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim',
            ['required' => 'Username harus diisi']
        );
        $this->form_validation->set_rules('password', 'Password', 'required|trim', ['required' => 'Password harus diisi']);

        if ($this->form_validation->run() == false) {
            $this->load->view('front_page/auth/login');
            $this->load->view('js-custom', $this->app_data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $hash = hash("sha256", $password . config_item('encryption_key'));

            $user = $this->db->where(['username' => $username, 'is_deleted' => '0', 'id_credential' => '2'])->get('st_user')->row_array();

            if ($user) {
                if ($user['is_aktif'] == '1') {
                    if ($hash == $user['password']) {
                        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;
                        $ip_address = $this->input->ip_address();
                        $data = array(
                            'ip_address' => $ip_address,
                            'date' => $timestamp
                        );
                        $this->data->insert('st_log_login', $data);

                        $data = [
                            'id' => $user['id'],
                            'email' => $user['email'],
                            'name' => $user['name']
                        ];
                        $this->session->set_userdata($data);
                        $this->session->set_userdata('logged_in_1', TRUE);
                        redirect('');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong>ERROR,  </strong>Password yang anda masukkan salah
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>');
                        redirect('');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                 <strong>Pemberitahuan,  </strong>Akun Anda belum terverifikasi. Silakan verifikasi akun Anda.
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>');
                    redirect('');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>ERROR,  </strong>Username yang anda masukkan tidak terdaftar
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
                redirect('');
            }
        }
    }

    public function register()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('telepon', 'No HP', 'required|trim|numeric');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[st_user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]');
        $this->form_validation->set_rules('password1', 'Ulangi', 'required|trim|matches[password]');


        if ($this->form_validation->run() == false) {
            $this->load->view('front_page/auth/registration');
            $this->load->view('js-custom', $this->app_data);
        } else {
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $telepon = $this->input->post('telepon');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $hash = hash("sha256", $password . config_item('encryption_key'));

            $data = array(
                'name' => $nama,
                'email' => $email,
                'phone_number' => $telepon,
                'username' => $username,
                'password' => $hash,
                'id_credential' => '2'
            );
            $insert = $this->data->insert('st_user', $data);


            if (!$insert) {
                $response['errors']['database'] = "Failed to update data in the database.";
            } else {
                if (!empty($_FILES['image']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/user/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = $username . '-' . $currentDateTime;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();
                        $file_name = $upload_data['file_name'];

                        $data = array('image' => $file_name);
                        $where = array('id' => $insert);
                        $this->data->update('st_user', $where, $data);
                    } else {
                        $response['errors']['image'] = strip_tags($this->upload->display_errors());
                    }
                }

                if (!empty($_FILES['ktp']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/user/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = $username . '-' . $currentDateTime;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('ktp')) {
                        $upload_data = $this->upload->data();
                        $file_name = $upload_data['file_name'];

                        $data = array('ktp' => $file_name);
                        $where = array('id' => $insert);
                        $this->data->update('st_user', $where, $data);
                    } else {
                        $response['errors']['image'] = strip_tags($this->upload->display_errors());
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
            redirect('');
        }
    }

    public function logout()
    {
        $data['user'] = $this->db->get_where('st_user', ['email' => $this->session->userdata('email')])->row_array();
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $where = array('id' => $data['user']['id']);
        $data = array('last_login' => $timestamp);
        $this->data->update('st_user', $where, $data);

        $this->session->unset_userdata('name');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('logged_in_1');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Anda telah logout,  </strong>Terima kasih sudah menggunakan sistem ini
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        redirect('');
    }
}
