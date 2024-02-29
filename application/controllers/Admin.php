<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    var $module_js = ['auth'];
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
            redirect('dashboard');
        }

        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim',
            ['required' => 'Username harus diisi']
        );
        $this->form_validation->set_rules('password', 'Password', 'required|trim', ['required' => 'Password harus diisi']);

        if ($this->form_validation->run() == false) {
            $this->load->view('menu-admin/login');
            $this->load->view('js-custom', $this->app_data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $hash = hash("sha256", $password . config_item('encryption_key'));

            $user = $this->db
                ->where(['username' => $username, 'is_deleted' => '0'])
                ->where_in('id_credential', 1)
                ->get('st_user')
                ->row_array();


            if ($user) {
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
                    $this->session->set_userdata('logged_in', TRUE);
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <strong>ERROR,  </strong>Password yang anda masukkan salah
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>');
                    redirect('admin');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ERROR,  </strong>Username yang anda masukkan tidak terdaftar
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
                redirect('admin');
            }
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
        $this->session->unset_userdata('logged_in');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Anda telah logout,  </strong>Terima kasih sudah menggunakan sistem ini
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        redirect('admin');
    }
}
