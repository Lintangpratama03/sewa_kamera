<?php

use chriskacerguis\RestServer\RestController;

require APPPATH . '/libraries/RestController.php';

class Manage_product extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model', 'product');
        $this->load->helper('url');
    }

    public function index_get()
    {
        $this->response($this->product->get_data(), RestController::HTTP_OK);
    }

    public function category_get()
    {
        $searchTerm = $this->input->get('searchTerm', TRUE);
        $this->response($this->product->get_data_category($searchTerm), RestController::HTTP_OK);
    }

    public function product_get()
    {
        $id = $this->input->get('id');
        $this->response($this->product->get_data_id($id), RestController::HTTP_OK);
    }

    public function insert_post()
    {
        $data = $this->post();
        $this->response($this->product->insert_data($data), RestController::HTTP_OK);
    }

    public function update_put()
    {
        $data = $this->put();
        $this->response($this->product->edit_data($data), RestController::HTTP_OK);
    }

    public function delete_delete()
    {
        $id = $this->delete('id');
        $this->response($this->product->delete_data($id), RestController::HTTP_OK);
    }
}
