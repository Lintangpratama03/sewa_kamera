<?php

class Product_model extends CI_Model
{
    public function get_data()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->db->get_where('st_user', $where)->row_array();

        $query = "
            SELECT a.*, b.name
            FROM product a
            JOIN product_has_category b ON b.id = a.id_category
            WHERE a.is_deleted = '0'
        ";
        $result = $this->db->query($query, array($data['user']['id']))->result();
        return $result;
    }

    public function get_data_category($searchTerm = null)
    {
        if ($searchTerm) {
            $query = "
                SELECT id, name
                FROM product_has_category
                WHERE name LIKE ?
            ";
            $data = $this->db->query($query, array("%$searchTerm%"))->result();
        } else {
            $query = "
                SELECT id, name
                FROM product_has_category
            ";
            $data = $this->db->query($query)->result();
        }

        return $data;
    }

    public function get_data_id($id)
    {
        $query = "
            SELECT a.*, b.name
            FROM product a
            JOIN product_has_category b ON b.id = a.id_category
            WHERE a.id = ?
        ";
        $result = $this->db->query($query, array($id))->result();
        return $result;
    }

    public function insert_data($data)
    {
        $where = array('email' => $this->session->userdata('email'));
        $user = $this->db->get_where('st_user', $where)->row_array();

        $insert_data = array(
            'nama_produk' => $data['judul'],
            'id_mitra' => $user['id'],
            'type' => $data['type'],
            'stok' => $data['stok'],
            'harga' => $data['harga'],
            'deskripsi' => $data['deskripsi'],
            'id_category' => $data['kategori'],
            'created_by' => $user['id'],
            'image' => $data['image']
        );

        $this->db->insert('product', $insert_data);
        return $this->db->affected_rows() > 0;
    }

    public function edit_data($data)
    {
        $where = array('email' => $this->session->userdata('email'));
        $user = $this->db->get_where('st_user', $where)->row_array();

        $update_data = array(
            'nama_produk' => $data['judul'],
            'type' => $data['type'],
            'stok' => $data['stok'],
            'harga' => $data['harga'],
            'deskripsi' => $data['deskripsi'],
            'id_category' => $data['kategori'],
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_by' => $user['id']
        );

        if (!empty($data['image'])) {
            $update_data['image'] = $data['image'];
        }

        $this->db->where('id', $data['id']);
        $this->db->update('product', $update_data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_data($id)
    {
        $where = array('email' => $this->session->userdata('email'));
        $user = $this->db->get_where('st_user', $where)->row_array();

        $update_data = array(
            'is_deleted' => '1',
            'deleted_date' => date('Y-m-d H:i:s'),
            'deleted_by' => $user['id']
        );

        $this->db->where('id', $id);
        $this->db->update('product', $update_data);
        return $this->db->affected_rows() > 0;
    }
}
