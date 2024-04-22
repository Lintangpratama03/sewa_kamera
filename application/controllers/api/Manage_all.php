<?php

use chriskacerguis\RestServer\RestController;

require APPPATH . '/libraries/RestController.php';

class Manage_all extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('All_model', 'all');
        $this->load->helper(['url', 'file']);
        $this->load->library('upload');
    }

    public function index_get()
    {
        $this->response($this->all->get_data(), RestController::HTTP_OK);
    }

    public function login_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');
        $this->response($this->all->login($email, $password), RestController::HTTP_OK);
    }

    public function get_produk_get()
    {
        $this->response($this->all->get_produk(), RestController::HTTP_OK);
    }

    public function get_produk_terbaru_get()
    {
        $this->response($this->all->get_produk_terbaru(), RestController::HTTP_OK);
    }

    public function get_produk_terlaris_get()
    {
        $this->response($this->all->get_produk_terlaris(), RestController::HTTP_OK);
    }

    public function get_category_get()
    {
        $this->response($this->all->get_category(), RestController::HTTP_OK);
    }

    public function get_detail_produk_get($id)
    {
        $this->response($this->all->get_detail_produk($id), RestController::HTTP_OK);
    }

    public function insert_keranjang_post()
    {
        $product_id = $this->post('product_id');
        $user_id = $this->post('user_id');
        $qty = $this->post('qty');
        $price = $this->post('price');
        $this->response($this->all->insert_keranjang($product_id, $user_id, $qty, $price), RestController::HTTP_OK);
    }

    public function get_keranjang_get()
    {
        $this->response($this->all->get_keranjang(), RestController::HTTP_OK);
    }

    public function get_mitra_get()
    {
        $this->response($this->all->get_mitra(), RestController::HTTP_OK);
    }

    public function delete_keranjang_delete($id)
    {
        $this->response($this->all->delete_keranjang($id), RestController::HTTP_OK);
    }

    public function update_qty_keranjang_put($id)
    {
        $qty = $this->put('qty');
        $this->response($this->all->update_qty_keranjang($id, $qty), RestController::HTTP_OK);
    }
}
