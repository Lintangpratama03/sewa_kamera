<?php

class All_model extends CI_Model
{
    public function get_data()
    {
        $data = $this->db->get('st_user')->result();
        return $data;
    }

    public function login($email, $password)
    {
        $data = $this->db->get_where('st_user', ['email' => $email, 'password' => $password])->row();
        if ($data) {
            $result = [
                "success" => "true",
                "message" => "Berhasil login!",
                "data" => $data
            ];
        } else {
            $result = [
                "success" => "false",
                "message" => "Gagal login!",
            ];
        }
        return $result;
    }

    public function get_produk()
    {
        $query = "
            SELECT p.id, p.id_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi
            FROM product p
            JOIN category c ON c.id = p.id_category
            LIMIT 3
        ";
        $data = $this->db->query($query)->result();
        $modifiedData = $this->modify_data($data, 'produk');
        return $modifiedData;
    }

    public function get_produk_terbaru()
    {
        $query = "
            SELECT p.id, p.id_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi
            FROM product p
            JOIN category c ON c.id = p.id_category
            ORDER BY p.created_date DESC
            LIMIT 3
        ";
        $data = $this->db->query($query)->result();
        $modifiedData = $this->modify_data($data, 'produk');
        return $modifiedData;
    }

    public function get_produk_terlaris()
    {
        $query = "
            SELECT p.id, p.id_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi
            FROM product p
            JOIN category c ON c.id = p.id_category
            ORDER BY p.created_date DESC
            LIMIT 3
        ";
        $data = $this->db->query($query)->result();
        $modifiedData = $this->modify_data($data, 'produk');
        return $modifiedData;
    }

    public function get_category()
    {
        $data = $this->db->get('category')->result();
        $modifiedData = $this->modify_data($data, 'category');
        return $modifiedData;
    }

    public function get_detail_produk($id)
    {
        $query = "
            SELECT p.id, p.id_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi
            FROM product p
            JOIN category c ON c.id = p.id_category
            WHERE p.id = $id
        ";
        $data = $this->db->query($query)->result();
        $modifiedData = $this->modify_data($data, 'produk');
        return $modifiedData;
    }

    public function insert_keranjang($product_id, $user_id, $qty, $price)
    {
        $cekData = $this->db->get_where('keranjang', ['product_id' => $product_id, 'user_id' => $user_id])->row();
        if ($cekData) {
            $this->db->where(['product_id' => $product_id, 'user_id' => $user_id])
                ->update('keranjang', [
                    'qty' => $cekData->qty + $qty,
                    'updated_date' => date('Y-m-d H:i:s')
                ]);
        } else {
            $data = [
                'product_id' => $product_id,
                'user_id' => $user_id,
                'qty' => $qty,
                'price' => $price,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'is_deleted' => 0
            ];
            $this->db->insert('keranjang', $data);
        }
        return [
            "success" => "true",
            'message' => 'Data keranjang berhasil disimpan'
        ];
    }

    public function get_keranjang()
    {
        $query = "
        SELECT k.id, p.id AS product_id, k.user_id, u.name AS nama_user, c.name AS nama_category,
        p.id_mitra, (SELECT um.name FROM st_user um WHERE um.id = p.id_mitra) AS nama_mitra,
        (SELECT um.image FROM st_user um WHERE um.id = p.id_mitra) AS image_mitra,
        k.qty, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi
        FROM keranjang k
        JOIN product p ON k.product_id = p.id
        JOIN st_user u ON u.id = k.user_id
        JOIN category c ON c.id = p.id_category
        WHERE k.user_id = 1
    ";
        $data = $this->db->query($query)->result();
        $modifiedData = $this->modify_data($data, 'produk');

        $result = [];
        foreach ($modifiedData as $key => $value) {
            $mitraFound = false;
            foreach ($result as &$item) {
                if ($item["id_mitra"] == $value->id_mitra) {
                    $item["produk"][] = [
                        "id" => $value->id,
                        "id_mitra" => $value->id_mitra,
                        "id_product" => $value->product_id,
                        "nama_produk" => $value->nama_produk,
                        "image" => $value->image,
                        "type" => $value->type,
                        "harga" => $value->harga,
                        "qty" => $value->qty,
                        "deskripsi" => $value->deskripsi,
                        "gambar_url" => $value->gambar_url,
                    ];
                    $mitraFound = true;
                    break;
                }
            }
            if (!$mitraFound) {
                $result[] = [
                    "id" => $value->id,
                    "id_mitra" => $value->id_mitra,
                    "nama_mitra" => $value->nama_mitra,
                    "image_mitra" => base_url('assets/image/user/' . $value->image_mitra),
                    "produk" => [
                        [
                            "id" => $value->id,
                            "id_mitra" => $value->id_mitra,
                            "id_product" => $value->product_id,
                            "nama_produk" => $value->nama_produk,
                            "image" => $value->image,
                            "type" => $value->type,
                            "harga" => $value->harga,
                            "qty" => $value->qty,
                            "deskripsi" => $value->deskripsi,
                            "gambar_url" => $value->gambar_url,
                        ]
                    ]
                ];
            }
        }
        return $result;
    }
    public function get_mitra()
    {
        $data = $this->db->get_where('st_user', ['id_credential' => 4])->result();
        $modifiedData = $this->modify_data($data, 'user');
        return $modifiedData;
    }

    public function delete_keranjang($id)
    {
        $this->db->delete('keranjang', ['id' => $id]);
        return [
            "success" => "true",
            'message' => 'Data keranjang berhasil dihapus'
        ];
    }

    public function update_qty_keranjang($id, $qty)
    {
        $this->db->update('keranjang', ['qty' => $qty], ['id' => $id]);
        return [
            "success" => "true",
            'message' => 'Data keranjang berhasil diupdate'
        ];
    }

    private function modify_data($data, $type)
    {
        $modifiedData = [];
        foreach ($data as $item) {
            if ($type == 'produk') {
                $namaGambar = $item->image;
                $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
                $item->gambar_url = $gambarUrl;
            } elseif ($type == 'category') {
                $namaGambar = $item->image_category;
                $gambarUrl = base_url('assets/image/category/' . $namaGambar);
                $item->gambar_url = $gambarUrl;
            } elseif ($type == 'user') {
                $namaGambar = $item->image;
                $gambarUrl = base_url('assets/image/user/' . $namaGambar);
                $item->gambar_url = $gambarUrl;
            }
            $modifiedData[] = $item;
        }
        return $modifiedData;
    }
}
