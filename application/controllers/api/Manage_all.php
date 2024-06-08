<?php

use chriskacerguis\RestServer\RestController;

require APPPATH . '/libraries/RestController.php';

class Manage_all extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['form', 'url']);
        $this->load->library('curl');
    }

    public function index_get()
    {
        $data = $this->db->get('st_user')->result();
        $this->response($data, RestController::HTTP_OK);
    }

    public function login_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');

        // Add conditions for id_credential and is_aktif in the query
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->where('id_credential', 3);
        $this->db->where('is_aktif', 1);
        $data = $this->db->get('st_user')->row();

        if ($data) {
            if (!is_null($data->image)) {
                $namaGambar = $data->image;
                $gambarUrl = base_url('assets/image/user/' . $namaGambar);
                $data->image = $gambarUrl;
            }

            $this->response([
                "success" => true,
                "message" => "Berhasil login !",
                "data" => $data
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                "success" => false,
                "message" => "Data tidak ada !",
            ], RestController::HTTP_NOT_FOUND);
        }
    }


    public function produk_get()
    {
        $data = $this->db->select('p.id, p.id_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
            ->from('product as p')
            ->join('category as c', 'c.id = p.id_category', 'left')
            ->where('p.is_deleted', 0)
            ->limit(3)
            ->get()
            ->result();

        $modifiedData = [];
        foreach ($data as $produk) {
            $namaGambar = $produk->image;
            $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
            $produk->gambar_url = $gambarUrl;
            $modifiedData[] = $produk;
        }
        $this->response($modifiedData, RestController::HTTP_OK);
    }
    public function produk_terbaru_get()
    {
        $data = $this->db->select('p.id, p.id_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
            ->from('product as p')
            ->join('category as c', 'c.id = p.id_category', 'left')
            ->where('p.is_deleted', 0)
            ->order_by('p.created_date', 'desc')
            ->limit(3)
            ->get()
            ->result();

        $modifiedData = [];
        foreach ($data as $produk) {
            $namaGambar = $produk->image;
            $sumRating = $this->db->select_sum('rating')->where('id_produk', $produk->id)->get('rating')->row()->rating;
            $sumRatingBagi = $this->db->where('id_produk', $produk->id)->count_all_results('rating');

            $produk->rating = ($sumRatingBagi != 0) ? ($sumRating / $sumRatingBagi) : 0;
            $produk->gambar_url = base_url('assets/image/produk/' . $namaGambar);
            $modifiedData[] = $produk;
        }
        $this->response($modifiedData, RestController::HTTP_OK);
    }
    public function get_category_get()
    {
        $data = $this->db->get('category')->result();

        $modifiedData = [];
        foreach ($data as $category) {
            $namaGambar = $category->image;
            $category->gambar_url = base_url('assets/image/kategori/' . $namaGambar);
            $modifiedData[] = $category;
        }
        $this->response($modifiedData, RestController::HTTP_OK);
    }

    public function get_detail_produk_get($id)
    {
        $data = $this->db->select('p.id, p.id_mitra, s.name as nama_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
            ->from('product as p')
            ->join('category as c', 'c.id = p.id_category', 'left')
            ->join('st_user as s', 's.id = p.id_mitra', 'left')
            ->where('p.is_deleted', 0)
            ->where('p.id', $id)
            ->get()
            ->result();

        $modifiedData = [];
        foreach ($data as $produk) {
            $namaGambar = $produk->image;
            $produk->gambar_url = base_url('assets/image/produk/' . $namaGambar);
            $sumRating = $this->db->select_sum('rating')->where('id_produk', $id)->get('rating')->row()->rating;
            $sumRatingBagi = $this->db->where('id_produk', $id)->count_all_results('rating');

            $produk->rating = ($sumRatingBagi != 0) ? ($sumRating / $sumRatingBagi) : 0;

            $modifiedData[] = $produk;
        }
        $this->response($modifiedData, RestController::HTTP_OK);
    }
    public function insert_keranjang_post()
    {
        $produkId = (int)$this->post('product_id');
        $userId = (int)$this->post('user_id');

        $cekData = $this->db->where('product_id', $produkId)
            ->where('user_id', $userId)
            ->get('keranjang')
            ->row();

        if ($cekData) {
            $this->db->where('product_id', $produkId)
                ->where('user_id', $userId)
                ->update('keranjang', [
                    'qty' => (int)$cekData->qty + (int)$this->post('qty'),
                    'updated_date' => date('Y-m-d H:i:s'),
                ]);
        } else {
            $this->db->insert('keranjang', [
                'product_id' => (int)$this->post('product_id'),
                'user_id' => (int)$this->post('user_id'),
                'qty' => (int)$this->post('qty'),
                'price' => (int)$this->post('price'),
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'is_deleted' => 0
            ]);
        }

        $this->response([
            "success" => true,
            'message' => 'Data keranjang berhasil disimpan'
        ], RestController::HTTP_OK);
    }

    public function get_keranjang_get($id)
    {
        $data = $this->db->select('k.id, p.id AS product_id, k.user_id, u.name as nama_user, c.name as nama_category, p.id_mitra, (SELECT um.name FROM st_user as um WHERE um.id = p.id_mitra) as nama_mitra, (SELECT um.image FROM st_user as um WHERE um.id = p.id_mitra) as image_mitra, k.qty, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
            ->from('keranjang as k')
            ->join('product as p', 'k.product_id = p.id', 'left')
            ->join('st_user as u', 'u.id = k.user_id', 'left')
            ->join('category as c', 'c.id = p.id_category', 'left')
            ->where('k.user_id', $id)
            ->get()
            ->result();

        $modifiedData = [];
        foreach ($data as $produk) {
            $namaGambar = $produk->image;
            $produk->gambar_url = base_url('assets/image/produk/' . $namaGambar);
            $modifiedData[] = $produk;
        }

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

        $this->response($result, RestController::HTTP_OK);
    }

    public function get_mitra_get()
    {
        $data = $this->db->select('id , name , image')
            ->where('id_credential', 2)
            ->where('is_aktif', 1)
            ->where('is_deleted', 0)
            ->get('st_user')
            ->result();

        $modifiedData = [];
        foreach ($data as $mitra) {
            $namaGambar = $mitra->image;
            $mitra->gambar_url = base_url('assets/image/user/' . $namaGambar);
            $modifiedData[] = $mitra;
        }
        $this->response($modifiedData, RestController::HTTP_OK);
    }

    public function delete_keranjang_delete($id)
    {
        $this->db->where('id', $id)->delete('keranjang');
        $this->response([
            "success" => true,
            'message' => 'Data keranjang berhasil dihapus'
        ], RestController::HTTP_OK);
    }

    public function update_qty_keranjang_put($id)
    {
        $this->db->where('id', $id)->update('keranjang', [
            "qty" => $this->put('qty')
        ]);
        $this->response([
            "success" => true,
            'message' => 'Data keranjang berhasil diupdate'
        ], RestController::HTTP_OK);
    }
    public function create_transaksi_booking_post()
    {
        $request_data = json_decode($this->post('data'), true);

        try {
            // Insert into the transaksi table
            $this->db->insert('transaksi', [
                'id_user' => (int)$this->post('id_user'),
                'status' => $this->post('status'),
                'tgl_pinjam' => $this->post('tgl_pinjam'),
                'tgl_tenggat' => $this->post('tgl_tenggat'),
                'tgl_booking' => $this->post('tgl_booking'),
                'id_mitra' => (int)$this->post('id_mitra'),
                'total_harga' => (int)$this->post('total_harga')
            ]);
            $transaksi_id = $this->db->insert_id();
            foreach ($request_data as $item) {
                $data = [
                    "id_produk" => (int)$item["id_produk"],
                    "id_transaksi" => $transaksi_id,
                    "jumlah" => (int)$item["jumlah"],
                    "sub_total" => (int)$item["sub_total"]
                ];
                $this->db->insert('detail_transaksi', $data);
            }


            $this->response([
                "success" => true,
                'message' => 'Berhasil mengajukan penyewaan barang, Harap Tunggu Mitra Verifikasi!'
            ], RestController::HTTP_OK);
        } catch (\Exception $e) {
            $this->response([
                "success" => false,
                'message' => 'Gagal mengajukan penyewaan barang: ' . $e->getMessage()
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function get_booking_transaksi_get($id)
    {
        $data = $this->db->select('t.id, t.status, t.total_harga, t.id_user')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra')
            ->where('t.id_user', $id)
            ->where('t.status', 'booking')
            ->get()
            ->result();

        $transactionsDetails = [];

        foreach ($data as $transaction) {
            $detail = $this->db->select('t.id, su.name as nama_mitra, t.status, p.image, p.nama_produk, dt.id_transaksi, dt.jumlah, p.harga, dt.sub_total as sub_harga, t.total_harga as total_all_produk')
                ->from('detail_transaksi as dt')
                ->join('product as p', 'p.id = dt.id_produk')
                ->join('transaksi as t', 't.id = dt.id_transaksi')
                ->join('st_user as su', 'su.id = p.id_mitra')
                ->where('dt.id_transaksi', $transaction->id)
                ->limit(1)
                ->get()
                ->row();

            $jumlah_all = $this->db->select_sum('jumlah')
                ->where('id_transaksi', $transaction->id)
                ->get('detail_transaksi')
                ->row();

            if ($detail) {
                $detail->jumlah_all_produk = (int)$jumlah_all->jumlah;
                $namaGambar = $detail->image;
                $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
                $detail->image = $gambarUrl;

                $transactionsDetails[] = $detail;
            }
        }

        $this->response($transactionsDetails, RestController::HTTP_OK);
    }


    public function get_terverifikasi_transaksi_get($id)
    {
        $data = $this->db->select('t.id, t.status, t.total_harga, t.id_user')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra')
            ->where('t.id_user', $id)
            ->where('t.status', 'terverifikasi')
            ->get()
            ->result();

        $transactionsDetails = [];

        foreach ($data as $transaction) {
            $detail = $this->db->select('t.id, su.name as nama_mitra, t.status, t.id_user, p.image, p.nama_produk, dt.id_transaksi, dt.jumlah, p.harga, dt.sub_total as sub_harga, t.total_harga as total_all_produk')
                ->from('detail_transaksi as dt')
                ->join('product as p', 'p.id = dt.id_produk')
                ->join('transaksi as t', 't.id = dt.id_transaksi')
                ->join('st_user as su', 'su.id = p.id_mitra')
                ->where('dt.id_transaksi', $transaction->id)
                ->limit(1)
                ->get()
                ->row();

            $jumlah_all = $this->db->select_sum('jumlah')
                ->where('id_transaksi', $transaction->id)
                ->get('detail_transaksi')
                ->row();

            if ($detail) {
                $detail->jumlah_all_produk = (int)$jumlah_all->jumlah;
                $namaGambar = $detail->image;
                $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
                $detail->image = $gambarUrl;

                $transactionsDetails[] = $detail;
            }
        }

        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    public function charge_post()
    {
        // Konfigurasi Midtrans
        $server_key = 'SB-Mid-server-d6Y8GDKsSkjqp_0W0kIujYDQ';
        $is_production = false;
        $api_url = $is_production ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        // Ambil data dari request body
        $requestBody = $this->post();

        $requestBody = json_encode($requestBody);
        $chargeResult = $this->chargeAPI($api_url, $server_key, $requestBody);

        $this->response($chargeResult['body'], $chargeResult['http_code']);
    }

    private function chargeAPI($api_url, $server_key, $request_body)
    {
        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($server_key . ':')
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($response) {
            return array(
                'body' => $response,
                'http_code' => $httpCode
            );
        } else {
            return array(
                'body' => 'Error: ' . curl_error($ch),
                'http_code' => $httpCode
            );
        }
    }

    public function get_detail_transaksi_bayar_get($id_user, $id_transaksi)
    {

        $this->db->select('t.id, t.total_harga, t.id_user, su.name, su.email, su.phone_number, su.ktp');
        $this->db->from('transaksi as t');
        $this->db->join('st_user as s', 's.id = t.id_mitra');
        $this->db->join('st_user as su', 'su.id = t.id_user');
        $this->db->where('t.id_user', $id_user);
        $this->db->where('t.id', $id_transaksi);
        $this->db->where('t.status', 'terverifikasi');
        $data = $this->db->get()->result_array();

        $transactionsDetails = [];

        foreach ($data as $value) {
            $this->db->select('dt.id, su.name as nama_mitra, p.nama_produk, dt.id_transaksi, dt.jumlah, p.harga, dt.sub_total as sub_harga');
            $this->db->from('detail_transaksi as dt');
            $this->db->join('product as p', 'p.id = dt.id_produk');
            $this->db->join('transaksi as t', 't.id = dt.id_transaksi');
            $this->db->join('st_user as su', 'su.id = p.id_mitra');
            $this->db->where('dt.id_transaksi', $value['id']);
            $detail = $this->db->get()->result_array();

            $transactionsDetails[] = [
                "id" => $value['id'],
                "name" => $value['name'],
                "email" => $value['email'],
                "phone_number" => $value['phone_number'],
                "ktp" => $value['ktp'],
                "total_harga" => $value['total_harga'],
                "id_user" => $value['id_user'],
                "product" => $detail
            ];
        }

        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    public function get_update_transaksi_status_post()
    {
        // Memperbarui status transaksi berdasarkan ID transaksi
        $id = (int) $this->post('id_transaksi');
        $data = [
            "transaction_id" => $this->post('transaction_id'),
            "status_bayar" => $this->post('transaction_status'),
            "tgl_transaksi" => $this->post('transaction_time'),
            "metode_pembayaran" => $this->post('payment_type'),
            "tanggal_expire" => $this->post('expiry_time'),
            "status" => $this->post('status'),
            "va_number" => $this->post('va_number')
        ];

        $this->db->where('id', $id);
        $this->db->update('transaksi', $data);

        $this->response([
            "success" => true,
            "message" => "Data berhasil diupdate"
        ], RestController::HTTP_OK);
    }

    public function get_update_status_expired_post()
    {
        // Memperbarui status transaksi yang kedaluwarsa berdasarkan ID transaksi
        $id = (int) $this->post('id_transaksi');
        $data = [
            "status" => $this->post('status'),
            "status_bayar" => $this->post('status_bayar')
        ];

        $this->db->where('id', $id);
        $this->db->update('transaksi', $data);

        $this->response([
            "success" => true,
            "message" => "Data berhasil diupdate"
        ], RestController::HTTP_OK);
    }
    public function register_post()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('ktp', 'KTP', 'required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Place of Birth', 'required');
        $this->form_validation->set_rules('alamat', 'Address', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('file_image', 'Profile Image', 'required');
        $this->form_validation->set_rules('file_ktp_image', 'KTP Image', 'required');

        if ($this->form_validation->run() === false) {
            $this->response([
                'status' => 0,
                'message' => 'Please adjust the email format!'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $email = $this->post('email');
            $cekEmailFound = $this->db->where('email', $email)->count_all_results('st_user');

            if ($cekEmailFound > 0) {
                $this->response([
                    'status' => 0,
                    'message' => 'Sorry, the email is already registered!'
                ], RestController::HTTP_BAD_REQUEST);
            } else {
                $file_p = $this->post('file_image');
                $file_k = $this->post('file_ktp_image');

                $dt_credential = $this->db->where('name', 'pelanggan')->get('app_credential')->row();
                $upload_path_p = 'user/' . $file_p;
                $upload_path_k = 'ktp/' . $file_k;
                $this->upload_base64($this->post('image'), $upload_path_p);
                $this->upload_base64($this->post('ktp_image'), $upload_path_k);

                $userData = [
                    'id_credential' => $dt_credential->id,
                    'name' => $this->post('name'),
                    'username' => $this->post('username'),
                    'email' => $this->post('email'),
                    'phone_number' => $this->post('phone_number'),
                    'tempat_lahir' => $this->post('tempat_lahir'),
                    'address' => $this->post('alamat'),
                    'password' => $this->post('password'),
                    'image' => $file_p,
                    'ktp' => $file_k,
                    'konfirmasi_by' => 0
                ];

                $this->db->insert('st_user', $userData);
                $this->response([
                    'status' => 1,
                    'message' => 'Registration successful!'
                ], RestController::HTTP_OK);
            }
        }
    }

    private function upload_base64($base64, $path)
    {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        $upload_path = FCPATH . 'assets/image/' . $path;
        file_put_contents($upload_path, $data);
    }

    public function get_dibayar_transaksi_get($id)
    {
        $data = $this->db->select('t.id, t.status, t.total_harga, t.id_user')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra', 'left')
            ->where('t.id_user', $id)
            ->where('t.status', 'bayar')
            ->get()->result();

        $transactionsDetails = $this->processTransactionDetails($data);
        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    public function get_cek_expired_get($id)
    {
        $data = $this->db->select('t.id, t.status, t.total_harga, t.id_user, t.transaction_id as order_id')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra', 'left')
            ->where('t.id_user', $id)
            ->where('t.status', 'bayar')
            ->get()->result();

        $transactionsDetails = $this->processTransactionDetails($data);
        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    public function get_lunas_transaksi_get($id)
    {
        $data = $this->db->select('t.id, t.status, t.total_harga, t.id_user')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra', 'left')
            ->where('t.id_user', $id)
            ->where('t.status', 'lunas')
            ->get()->result();

        $transactionsDetails = $this->processTransactionDetails($data);
        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    public function get_dipinjam_transaksi_get($id)
    {
        $data = $this->db->select('t.id, t.status, t.total_harga, t.id_user')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra', 'left')
            ->where('t.id_user', $id)
            ->where('t.status', 'dipinjam')
            ->get()->result();

        $transactionsDetails = $this->processTransactionDetails($data);
        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    public function get_selesai_transaksi_get($id)
    {
        $data = $this->db->select('t.id, t.status, t.total_harga, t.id_user')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra', 'left')
            ->where('t.id_user', $id)
            ->where('t.status', 'selesai')
            ->get()->result();

        $transactionsDetails = $this->processTransactionDetails($data, true);
        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    public function get_expired_transaksi_get($id)
    {
        $data = $this->db->select('t.id, t.status, t.total_harga, t.id_user')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra', 'left')
            ->where('t.id_user', $id)
            ->where('t.status', 'kadaluarsa')
            ->get()->result();

        $transactionsDetails = $this->processTransactionDetails($data);
        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    private function processTransactionDetails($data, $checkRating = false)
    {
        $transactionsDetails = [];

        foreach ($data as $transaction) {
            $detail = $this->db->select('t.id, su.name as nama_mitra, t.status, p.image, p.nama_produk, dt.id_transaksi, dt.jumlah, p.harga, dt.sub_total as sub_harga, t.total_harga as total_all_produk')
                ->from('detail_transaksi as dt')
                ->join('product as p', 'p.id = dt.id_produk', 'left')
                ->join('transaksi as t', 't.id = dt.id_transaksi', 'left')
                ->join('st_user as su', 'su.id = p.id_mitra', 'left')
                ->where('dt.id_transaksi', $transaction->id)
                ->limit(1)
                ->get()->row();

            $jumlah_all = $this->db->select_sum('jumlah')
                ->from('detail_transaksi')
                ->where('id_transaksi', $transaction->id)
                ->get()->row()->jumlah;

            if ($detail) {
                $detail->jumlah_all_produk = (int)$jumlah_all;
                $namaGambar = $detail->image;
                $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
                $detail->image = $gambarUrl;

                if ($checkRating) {
                    $cekRating = $this->db->where('id_transaksi', $transaction->id)->count_all_results('rating_transaksi');
                    $detail->isRating = ($cekRating > 0) ? 'true' : 'false';
                }

                $transactionsDetails[] = $detail;
            }
        }

        return $transactionsDetails;
    }
    public function get_list_produk_get()
    {
        $type = $this->get('type');
        $message = $this->get('message');

        if ($type == "search") {
            $data = $this->db->select('p.id, p.id_mitra, s.name as nama_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
                ->from('product as p')
                ->join('category as c', 'c.id = p.id_category', 'left')
                ->join('st_user as s', 's.id = p.id_mitra', 'left')
                ->order_by('p.created_date', 'desc')
                ->like('p.nama_produk', "%{$message}%", 'both')
                ->or_like('c.name', "%{$message}%", 'both')
                ->or_like('s.name', "%{$message}%", 'both')
                ->get()->result();

            $modifiedData = $this->processProductData($data);
        } elseif ($type == "filter") {
            if ($message == "terlama") {
                $data = $this->db->select('p.id, p.id_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
                    ->from('product as p')
                    ->join('category as c', 'c.id = p.id_category', 'left')
                    ->order_by('p.created_date', 'asc')
                    ->get()->result();

                $modifiedData = $this->processProductData($data);
            } elseif ($message == "terbaru") {
                $data = $this->db->select('p.id, p.id_mitra, s.name as nama_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
                    ->from('product as p')
                    ->join('category as c', 'c.id = p.id_category', 'left')
                    ->join('st_user as s', 's.id = p.id_mitra', 'left')
                    ->order_by('p.created_date', 'desc')
                    ->get()->result();

                $modifiedData = $this->processProductData($data);
            } else {
                $data = $this->db->select('p.id, p.id_mitra, s.name as nama_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
                    ->from('product as p')
                    ->join('category as c', 'c.id = p.id_category', 'left')
                    ->join('st_user as s', 's.id = p.id_mitra', 'left')
                    ->get()->result();

                $modifiedData = $this->processProductData($data);
            }
        } elseif ($type == "filter_categori") {
            $data = $this->db->select('p.id, p.id_mitra, s.name as nama_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
                ->from('product as p')
                ->join('category as c', 'c.id = p.id_category', 'left')
                ->join('st_user as s', 's.id = p.id_mitra', 'left')
                ->where('c.name', $message)
                ->order_by('p.created_date', 'desc')
                ->get()->result();

            $modifiedData = $this->processProductData($data);
        } else {
            $data = $this->db->select('p.id, p.id_mitra, s.name as nama_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
                ->from('product as p')
                ->join('category as c', 'c.id = p.id_category', 'left')
                ->join('st_user as s', 's.id = p.id_mitra', 'left')
                ->get()->result();

            $modifiedData = $this->processProductData($data);
        }

        $this->response($modifiedData, RestController::HTTP_OK);
    }

    private function processProductData($data)
    {
        $modifiedData = [];
        foreach ($data as $produk) {
            $namaGambar = $produk->image;
            $sumRating = $this->db->select_sum('rating')
                ->where('id_produk', $produk->id)
                ->get('rating')->row()->rating;

            $sumRatingBagi = $this->db->where('id_produk', $produk->id)
                ->count_all_results('rating');

            $produk->rating = ($sumRatingBagi != 0) ? ($sumRating / $sumRatingBagi) : 0;
            $produk->gambar_url = base_url('assets/image/produk/' . $namaGambar);
            $modifiedData[] = $produk;
        }
        return $modifiedData;
    }

    public function get_category_spinner_get()
    {
        $data = $this->db->get('category')->result();
        $this->response($data, RestController::HTTP_OK);
    }

    public function get_detail_mitra_get($id)
    {
        $data = $this->db->select('s.name, COUNT(p.id) as total_products')
            ->from('product as p')
            ->join('category as c', 'c.id = p.id_category', 'left')
            ->join('st_user as s', 's.id = p.id_mitra', 'left')
            ->where('p.id_mitra', $id)
            ->group_by('s.name')
            ->get()->row();

        $data2 = $this->db->select('p.id, p.id_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
            ->from('product as p')
            ->join('category as c', 'c.id = p.id_category', 'left')
            ->join('st_user as s', 's.id = p.id_mitra', 'left')
            ->where('p.id_mitra', $id)
            ->order_by('p.created_date', 'desc')
            ->get()->result();

        $modifiedData = [
            "nama_mitra" => $data->name,
            "total_products" => $data->total_products,
            "produk" => $this->processProductData($data2)
        ];

        $this->response($modifiedData, RestController::HTTP_OK);
    }
    public function get_detail_history_get()
    {
        $id = $this->get('id');
        $transaction_id = $this->get('transaction_id');

        $data = $this->db->select('t.id, t.id_user, t.transaction_id, t.status, t.tgl_booking, t.tgl_pinjam, t.tgl_tenggat, t.tgl_terverifikasi, t.tgl_terima, t.tgl_transaksi, t.tgl_selesai, t.metode_pembayaran, t.status_bayar, t.total_harga, t.tanggal_expire, t.va_number')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra', 'left')
            ->where('t.id_user', $id)
            ->where('t.id', $transaction_id)
            ->get()
            ->result();

        $transactionsDetails = [];

        foreach ($data as $transaction) {
            $detail = $this->db->select('t.id, p.image, p.nama_produk, dt.jumlah, dt.sub_total')
                ->from('detail_transaksi as dt')
                ->join('product as p', 'p.id = dt.id_produk', 'left')
                ->join('transaksi as t', 't.id = dt.id_transaksi', 'left')
                ->join('st_user as su', 'su.id = p.id_mitra', 'left')
                ->where('dt.id_transaksi', $transaction->id)
                ->get()
                ->result();

            foreach ($detail as $key => $value) {
                if ($detail) {
                    $namaGambar = $value->image;
                    $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
                    $value->image = $gambarUrl;
                }
            }

            $transactionsDetails[] = [
                "id" => $transaction->id,
                "id_user" => $transaction->id_user,
                "status" => $transaction->status,
                "transaction_id" => $transaction->transaction_id,
                "tgl_booking" => $transaction->tgl_booking,
                "tgl_pinjam" => $transaction->tgl_pinjam,
                "tgl_tenggat" => $transaction->tgl_tenggat,
                "tgl_terverifikasi" => $transaction->tgl_terverifikasi,
                "tgl_terima" => $transaction->tgl_terima,
                "tgl_transaksi" => $transaction->tgl_transaksi,
                "tgl_selesai" => $transaction->tgl_selesai,
                "metode_pembayaran" => $transaction->metode_pembayaran,
                "status_bayar" => $transaction->status_bayar,
                "total_harga" => $transaction->total_harga,
                "tanggal_expire" => $transaction->tanggal_expire,
                "va_number" => $transaction->va_number,
                "product" => $detail
            ];
        }

        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    public function get_produk_rating_get()
    {
        $id = $this->get('id');
        $transaction_id = $this->get('transaction_id');

        $data = $this->db->select('t.id, t.id_user')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra', 'left')
            ->where('t.id_user', $id)
            ->where('t.id', $transaction_id)
            ->get()
            ->result();

        $transactionsDetails = [];

        foreach ($data as $transaction) {
            $detail = $this->db->select('t.id, dt.id_produk, p.image, p.nama_produk, dt.jumlah, dt.sub_total')
                ->from('detail_transaksi as dt')
                ->join('product as p', 'p.id = dt.id_produk', 'left')
                ->join('transaksi as t', 't.id = dt.id_transaksi', 'left')
                ->join('st_user as su', 'su.id = p.id_mitra', 'left')
                ->where('dt.id_transaksi', $transaction->id)
                ->get()
                ->result();

            foreach ($detail as $key => $value) {
                if ($detail) {
                    $namaGambar = $value->image;
                    $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
                    $value->image = $gambarUrl;
                }
            }

            $transactionsDetails[] = [
                "id" => $transaction->id,
                "id_user" => $transaction->id_user,
                "product" => $detail
            ];
        }

        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    public function create_data_rating_post()
    {
        $id_user = $this->post('id_user');
        $id_transaksi = $this->post('id_transaksi');
        $datanya = json_decode($this->post('data'), true);

        try {
            $transaksi = $this->db->insert('rating_transaksi', [
                'id_user' => $id_user,
                'id_transaksi' => $id_transaksi
            ]);

            foreach ($datanya as $item) {
                $data = [
                    "id_rating_transaksi" => $this->db->insert_id(),
                    "id_user" => $id_user,
                    "id_produk" => $item["id_produk"],
                    "rating" => $item["rating"],
                    "deskripsi" => $item["deskripsi"]
                ];
                $this->db->insert('rating', $data);
            }

            $this->response([
                "success" => true,
                'message' => 'Terima Kasih telah memberikan penilaian !'
            ], RestController::HTTP_OK);
        } catch (Exception $e) {
            $this->response([
                "success" => false,
                'message' => 'Gagal memberikan rating produk: ' . $e->getMessage()
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_rekomendasi_produk_get()
    {
        $data = $this->db->select('p.id, p.id_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
            ->from('product as p')
            ->join('category as c', 'c.id = p.id_category', 'left')
            ->order_by('p.created_date', 'desc')
            ->limit(3)
            ->get()
            ->result();

        $modifiedData = [];
        foreach ($data as $produk) {
            $namaGambar = $produk->image;
            $sumRating = $this->db->select_sum('rating')->where('id_produk', $produk->id)->get('rating')->row()->rating;
            $sumRatingBagi = $this->db->where('id_produk', $produk->id)->count_all_results('rating');

            $produk->rating = ($sumRatingBagi != 0) ? ($sumRating / $sumRatingBagi) : 0;
            $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
            $produk->gambar_url = $gambarUrl;
            $modifiedData[] = $produk;
        }
        $this->response($modifiedData, RestController::HTTP_OK);
    }

    public function get_detail_rating_get($id)
    {
        $data = $this->db->select('r.id, s.name as nama_user, r.rating, r.id_produk, r.id_user, r.deskripsi, p.nama_produk, p.image')
            ->from('rating as r')
            ->join('product as p', 'p.id = r.id_produk', 'left')
            ->join('st_user as s', 's.id = r.id_user', 'left')
            ->where('r.id_produk', $id)
            ->get()
            ->result();

        $modifiedData = [];
        foreach ($data as $produk) {
            $namaGambar = $produk->image;
            $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
            $produk->gambar_url = $gambarUrl;
            $modifiedData[] = $produk;
        }
        $this->response($modifiedData, RestController::HTTP_OK);
    }

    public function get_detail_ulasan_get($id)
    {
        $data = $this->db->select('r.id, s.name as nama_user, r.rating, r.id_produk, r.id_user, r.deskripsi, p.nama_produk, p.image')
            ->from('rating as r')
            ->join('product as p', 'p.id = r.id_produk', 'left')
            ->join('st_user as s', 's.id = r.id_user', 'left')
            ->where('r.id_user', $id)
            ->get()
            ->result();

        $modifiedData = [];
        foreach ($data as $produk) {
            $namaGambar = $produk->image;
            $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
            $produk->gambar_url = $gambarUrl;
            $modifiedData[] = $produk;
        }
        $this->response($modifiedData, RestController::HTTP_OK);
    }

    public function get_profile_get($id)
    {
        $data = $this->db->select('id, name, email, phone_number, tempat_lahir, image, ktp, username, ktp_image, tanggal_lahir, alamat')
            ->from('st_user')
            ->where('id', $id)
            ->get()
            ->result();

        $modifiedData = [];
        foreach ($data as $user) {
            $namaGambar = $user->image;
            if ($namaGambar != "" && $namaGambar != null && $namaGambar != "null") {
                $gambarUrl = base_url('assets/image/user/' . $namaGambar);
                $user->image = $gambarUrl;
            }
            $namaGambar2 = $user->ktp_image;
            if ($namaGambar2 != "" && $namaGambar2 != null && $namaGambar2 != "null") {
                $gambarUrl2 = base_url('assets/image/ktp/' . $namaGambar2);
                $user->ktp_image = $gambarUrl2;
            }
            $modifiedData[] = $user;
        }
        $this->response($modifiedData, RestController::HTTP_OK);
    }

    public function update_profile_post()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('ktp', 'KTP', 'required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('file_image', 'File Image', 'required');
        $this->form_validation->set_rules('file_ktp_image', 'File KTP Image', 'required');

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            $this->response([
                'status' => 0,
                'message' => 'Harap menyesuaikan emailnya !',
                'errors' => $errors
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $id = $this->post('id');
            $email = $this->post('email');

            $cekEmailFound = $this->db->where('id !=', $id)->where('email', $email)->count_all_results('st_user');

            if ($cekEmailFound > 0) {
                $this->response([
                    'status' => 0,
                    'message' => 'Maaf email sudah terdaftar !'
                ], RestController::HTTP_BAD_REQUEST);
            } else {
                $file_p = $this->post('file_image');
                $file_k = $this->post('file_ktp_image');
                $this->load->helper('file');
                write_file('./assets/image/user/' . $file_p, base64_decode($this->post('image')));
                write_file('./assets/image/ktp/' . $file_k, base64_decode($this->post('ktp_image')));
                $data = [
                    'name' => $this->post('name'),
                    'username' => $this->post('username'),
                    'email' => $this->post('email'),
                    'ktp' => $this->post('ktp'),
                    'phone_number' => $this->post('phone_number'),
                    'tempat_lahir' => $this->post('tempat_lahir'),
                    'alamat' => $this->post('alamat'),
                    'image' => $file_p,
                    'ktp_image' => $file_k
                ];
                $this->db->where('id', $id)->update('st_user', $data);
                $this->response([
                    'status' => 1,
                    'message' => 'Berhasil melakukan update profile !'
                ], RestController::HTTP_OK);
            }
        }
    }

    public function update_password_post()
    {
        // Implement update password logic here
    }
}
