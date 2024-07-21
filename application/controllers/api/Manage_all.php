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

    // public function login_post()
    // {
    //     $email = $this->post('email');
    //     $password = $this->post('password');

    //     // Add conditions for id_credential and is_aktif in the query
    //     $this->db->where('email', $email);
    //     $this->db->where('password', $password);
    //     $this->db->where('id_credential', 3);
    //     $this->db->where('is_aktif', 1);
    //     $data = $this->db->get('st_user')->row();

    //     if ($data) {
    //         if (!is_null($data->image)) {
    //             $namaGambar = $data->image;
    //             $gambarUrl = base_url('assets/image/user/' . $namaGambar);
    //             $data->image = $gambarUrl;
    //         }

    //         $this->response([
    //             "success" => true,
    //             "message" => "Berhasil login !",
    //             "data" => $data
    //         ], RestController::HTTP_OK);
    //     } else {
    //         $this->response([
    //             "success" => false,
    //             "message" => "Data tidak ada !",
    //         ], RestController::HTTP_NOT_FOUND);
    //     }
    // }
    public function login_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');

        $data = $this->db->where('email', $email)
            ->where('password', $password)
            ->where('id_credential', 3)
            ->where('is_aktif', 1)
            ->get('st_user')
            ->row();

        if (!is_null($data)) {
            if (!is_null($data->image)) {
                $namaGambar = $data->image;
                $gambarUrl = base_url('assets/image/user/' . $namaGambar);
                $data->image = $gambarUrl;
            }

            $result = [
                "success" => true,
                "message" => "Berhasil login !",
                "data" => $data
            ];
        } else {
            $result = [
                "success" => false,
                "message" => "Data tidak ada !"
            ];
        }

        $this->response($result, RestController::HTTP_OK);
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
            ->where('p.is_aktif', 1)
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
    public function produk_terlaris_get()
    {
        $data = $this->db->select('p.id, p.id_mitra, c.name as id_category, p.nama_produk, p.image, p.type, p.harga, p.stok, p.deskripsi')
            ->from('product as p')
            ->join('category as c', 'c.id = p.id_category', 'left')
            ->where('p.is_deleted', 0)
            ->order_by('p.created_date', 'asc')
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
                $detail->id_user = (int)$detail->id_user;
                $detail->sub_harga = (int)$detail->sub_harga;
                $detail->total_all_produk = (int)$detail->total_all_produk;
                $detail->harga = (int)$detail->harga;
                $detail->id = (int)$detail->id;
                $detail->id_transaksi = (int)$detail->id_transaksi;
                $detail->jumlah = (int)$detail->jumlah;
                $namaGambar = $detail->image;
                $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
                $detail->image = $gambarUrl;

                $transactionsDetails[] = $detail;
            }
        }

        $this->response($transactionsDetails, RestController::HTTP_OK);
    }

    // public function charge_post()
    // {
    //     // Konfigurasi Midtrans
    //     $server_key = 'SB-Mid-server-d6Y8GDKsSkjqp_0W0kIujYDQ';
    //     $is_production = false;
    //     $api_url = $is_production ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

    //     // Ambil data dari request body
    //     $requestBody = file_get_contents('php://input');
    //     $requestData = json_decode($requestBody, true); // Decode JSON request body to associative array

    //     if (!$requestData) {
    //         $this->response(['message' => 'Invalid JSON format'], RestController::HTTP_BAD_REQUEST);
    //         return;
    //     }

    //     // Charge the API
    //     $chargeResult = $this->chargeAPI($api_url, $server_key, $requestData);

    //     // Return response
    //     $this->response($chargeResult['body'], $chargeResult['http_code'])->header('Content-Type', 'application/json');
    // }

    // function chargeAPI($api_url, $server_key, $request_data)
    // {
    //     $curl = curl_init();

    //     $payload = json_encode($request_data);

    //     $authorization = base64_encode($server_key . ':');
    //     $headers = array(
    //         'Content-Type: application/json',
    //         'Accept: application/json',
    //         'Authorization: Basic ' . $authorization
    //     );

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $api_url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => $payload,
    //         CURLOPT_HTTPHEADER => $headers,
    //     ));

    //     $response = curl_exec($curl);
    //     $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    //     curl_close($curl);

    //     return array(
    //         'body' => $response,
    //         'http_code' => $httpCode
    //     );
    // }

    public function charge_post()
    {
        // Set your server key (Note: Server key for sandbox and production mode are different)
        $server_key = 'SB-Mid-server-d6Y8GDKsSkjqp_0W0kIujYDQ';
        // Set true for production, set false for sandbox
        $is_production = false;
        $api_url = $is_production ?
            'https://app.midtrans.com/snap/v1/transactions' :
            'https://app.sandbox.midtrans.com/snap/v1/transactions';

        // Check if method is not HTTP POST, display 404
        if ($this->input->method() !== 'post') {
            show_404();
        }

        // Get the HTTP POST body of the request
        $request_body = file_get_contents('php://input');

        // Call charge API using request body passed by mobile SDK
        $charge_result = $this->chargeAPI($api_url, $server_key, $request_body);

        // Set the response http status code
        $this->output->set_status_header($charge_result['http_code']);

        // Then print out the response body
        $this->output->set_output($charge_result['body']);
    }

    /**
     * Call charge API using Curl
     * @param string  $api_url
     * @param string  $server_key
     * @param string  $request_body
     */
    private function chargeAPI($api_url, $server_key, $request_body)
    {
        $ch = curl_init();
        $curl_options = array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            // Add header to the request, including Authorization generated from server key
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($server_key . ':')
            ),
            CURLOPT_POSTFIELDS => $request_body
        );
        curl_setopt_array($ch, $curl_options);
        $result = array(
            'body' => curl_exec($ch),
            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        );
        return $result;
    }
    public function get_detail_transaksi_bayar_get()
    {
        // Get request parameters from URL
        $id_user = $this->input->get('id_user');
        $id_transaksi = $this->input->get('id_transaksi');

        if (is_null($id_user) || is_null($id_transaksi)) {
            $this->response(['message' => 'Missing parameters'], RestController::HTTP_BAD_REQUEST);
            return;
        }

        $this->db->select([
            't.id',
            't.total_harga',
            't.id_user',
            'su.name',
            'su.email',
            'su.phone_number',
            'su.ktp'
        ]);
        $this->db->from('transaksi t');
        $this->db->join('st_user su', 'su.id = t.id_user', 'left');
        $this->db->where('t.id_user', $id_user);
        $this->db->where('t.id', $id_transaksi);
        $this->db->where('t.status', 'terverifikasi');
        $transaction_data = $this->db->get()->row();

        if ($transaction_data) {
            $this->db->select([
                'dt.id',
                'su.name as nama_mitra',
                'p.nama_produk',
                'dt.id_transaksi',
                'dt.jumlah',
                'p.harga',
                'dt.sub_total as sub_harga'
            ]);
            $this->db->from('detail_transaksi dt');
            $this->db->join('product p', 'p.id = dt.id_produk', 'left');
            $this->db->join('transaksi t', 't.id = dt.id_transaksi', 'left');
            $this->db->join('st_user su', 'su.id = p.id_mitra', 'left');
            $this->db->where('dt.id_transaksi', $transaction_data->id);
            $details = $this->db->get()->result();

            $detailsArray = [];
            foreach ($details as $detail) {
                $detailsArray[] = [
                    "id" => (int)$detail->id,
                    "nama_mitra" => $detail->nama_mitra,
                    "nama_produk" => $detail->nama_produk,
                    "id_transaksi" => (int)$detail->id_transaksi,
                    "jumlah" => (int)$detail->jumlah,
                    "harga" => (int)$detail->harga,
                    "sub_harga" => (int)$detail->sub_harga
                ];
            }

            $transaction = [
                "id" => (int)$transaction_data->id,  // Cast to int
                "name" => $transaction_data->name,
                "email" => $transaction_data->email,
                "phone_number" => $transaction_data->phone_number,
                "ktp" => $transaction_data->ktp,
                "total_harga" => (int)$transaction_data->total_harga,  // Cast to int
                "id_user" => (int)$transaction_data->id_user,  // Cast to int
                "product" => $detailsArray
            ];

            $this->response([$transaction], RestController::HTTP_OK);
        } else {
            $this->response(['message' => 'Transaction not found or not verified'], RestController::HTTP_NOT_FOUND);
        }
    }




    public function get_update_transaksi_status_post()
    {
        // Memperbarui status transaksi berdasarkan ID transaksi
        $id = $this->input->get('id_transaksi');
        $transaction_id = $this->input->get('transaction_id');
        $transaction_status = $this->input->get('transaction_status');
        $data = [
            "transaction_id" => $transaction_id,
            "status_bayar" => $transaction_status,
            "tgl_transaksi" => $this->input->get('transaction_time'),
            "metode_pembayaran" => $this->input->get('payment_type'),
            "tanggal_expire" => $this->input->get('expiry_time'),
            "status" => $this->input->get('status'),
            "va_number" => $this->input->get('va_number')
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
        // Validate the ID transaksi
        $id = $this->post('id_transaksi');
        // $this->response($id);
        if (!$id) {
            return $this->response([
                "success" => false,
                "message" => "ID transaksi tidak valid"
            ], RestController::HTTP_BAD_REQUEST);
        }

        // Validate and sanitize the input data
        $status = $this->post('status');
        $status_bayar = $this->post('status_bayar');

        if (empty($status) || empty($status_bayar)) {
            return $this->response([
                "success" => false,
                "message" => "Status dan status bayar harus diisi"
            ], RestController::HTTP_BAD_REQUEST);
        }

        // Prepare the data array
        $data = [
            "status" => $status,
            "status_bayar" => $status_bayar
        ];

        // Update the transaction status
        $this->db->where('id', $id);
        $update = $this->db->update('transaksi', $data);

        // Check if the update was successful
        if ($update) {
            return $this->response([
                "success" => true,
                "message" => "Data berhasil diupdate"
            ], RestController::HTTP_OK);
        } else {
            return $this->response([
                "success" => false,
                "message" => "Gagal mengupdate data"
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register_post()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('ktp', 'KTP', 'required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('file_image', 'File Image', 'required');
        $this->form_validation->set_rules('file_ktp_image', 'File KTP Image', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => 0,
                'message' => 'Harap menyesuaikan emailnya !'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $email = $this->post('email');

            $cekEmailFound = $this->db->where('email', $email)->count_all_results('st_user');

            if ($cekEmailFound > 0) {
                $this->response([
                    'status' => 0,
                    'message' => 'Maaf email sudah terdaftar !'
                ], RestController::HTTP_BAD_REQUEST);
            } else {
                $file_p = $this->post('file_image');
                $file_k = $this->post('file_ktp_image');

                $dt_credential = $this->db->where('name', 'pelanggan')->get('app_credential')->row();

                if ($dt_credential) {
                    $this->load->helper('file');

                    write_file('./assets/image/user/' . $file_p, base64_decode($this->post('image')));
                    write_file('./assets/image/ktp/' . $file_k, base64_decode($this->post('ktp_image')));

                    $user_data = [
                        'id_credential' => $dt_credential->id,
                        'name' => $this->post('name'),
                        'username' => $this->post('username'),
                        'email' => $this->post('email'),
                        'ktp' => $this->post('ktp'),
                        'phone_number' => $this->post('phone_number'),
                        'tempat_lahir' => $this->post('tempat_lahir'),
                        'address' => $this->post('alamat'),
                        'password' => $this->post('password'),
                        'image' => $file_p,
                        'ktp_image' => $file_k,
                        'konfirmasi_by' => 0,
                    ];

                    $this->db->insert('st_user', $user_data);

                    $this->response([
                        'status' => 1,
                        'message' => 'Berhasil melakukan registrasi !'
                    ], RestController::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 0,
                        'message' => 'Credential pelanggan tidak ditemukan!'
                    ], RestController::HTTP_BAD_REQUEST);
                }
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
            $detail = $this->db->select('t.transaction_id as order_id, t.id, su.name as nama_mitra, t.status, p.image, p.nama_produk, dt.id_transaksi, dt.jumlah, p.harga, dt.sub_total as sub_harga, t.total_harga as total_all_produk')
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
        $type = $this->input->get('type');
        $message = $this->input->get('message');

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
        $id = $this->input->get('id');
        $transaction_id = $this->input->get('transaction_id');

        $data = $this->db->select('t.id, t.id_user, t.transaction_id, t.status, t.tgl_booking, t.tgl_pinjam, t.tgl_tenggat, t.tgl_verifikasi, t.tgl_terima, t.tgl_transaksi, t.tgl_selesai, t.metode_pembayaran, t.status_bayar, t.total_harga, t.tanggal_expire, t.va_number')
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
                "tgl_terverifikasi" => $transaction->tgl_verifikasi,
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
        $id = $this->input->get('id');
        $transaction_id = $this->input->get('transaction_id');

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
        $data = $this->db->select('id, name, email, phone_number, tempat_lahir, image, ktp, username, ktp_image, tanggal_lahir, address as alamat')
            ->where('id', $id)
            ->get('st_user')
            ->result();

        $modifiedData = [];
        foreach ($data as $user) {
            $namaGambar = $user->image;
            if (!empty($namaGambar) && $namaGambar != "null") {
                $gambarUrl = base_url('assets/image/user/' . $namaGambar);
                $user->image_url = $gambarUrl;
            } else {
                $user->image_url = null;
            }

            $namaGambar2 = $user->ktp_image;
            if (!empty($namaGambar2) && $namaGambar2 != "null") {
                $gambarUrl2 = base_url('assets/image/ktp/' . $namaGambar2);
                $user->ktp_image_url = $gambarUrl2;
            } else {
                $user->ktp_image_url = null;
            }

            $modifiedData[] = $user;
        }

        $this->response($modifiedData, RestController::HTTP_OK);
    }

    public function update_profile_post()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('ktp', 'KTP', 'required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => 0,
                'message' => 'Harap menyesuaikan emailnya !'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $id = $this->post('id');
            $email = $this->post('email');

            $cekEmailFound = $this->db->where('email', $email)
                ->where_not_in('id', $id)
                ->count_all_results('st_user');

            if ($cekEmailFound > 0) {
                $this->response([
                    'status' => 0,
                    'message' => 'Maaf email sudah terdaftar !'
                ], RestController::HTTP_BAD_REQUEST);
            } else {
                $updateData = [
                    'name' => $this->post('name'),
                    'username' => $this->post('username'),
                    'email' => $this->post('email'),
                    'ktp' => $this->post('ktp'),
                    'phone_number' => $this->post('phone_number'),
                    'tempat_lahir' => $this->post('tempat_lahir'),
                    'tanggal_lahir' => $this->post('tanggal_lahir'),
                    'address' => $this->post('alamat')
                ];

                // Handle file_image
                if (!is_null($this->post('file_image'))) {
                    $user = $this->db->where('id', $id)->get('st_user')->row();
                    if ($user->image != null) {
                        $gambar_path = FCPATH . "assets/image/user/{$user->image}";
                        if (file_exists($gambar_path)) {
                            unlink($gambar_path);
                        }
                    }
                    $file_p = $this->post('file_image');
                    write_file('./assets/image/user/' . $file_p, base64_decode($this->post('image')));
                    $updateData['image'] = $file_p;
                }

                // Handle file_ktp_image
                if (!is_null($this->post('file_ktp_image'))) {
                    $user = $this->db->where('id', $id)->get('st_user')->row();
                    if ($user->ktp_image != null) {
                        $gambar_path = FCPATH . "assets/image/ktp/{$user->ktp_image}";
                        if (file_exists($gambar_path)) {
                            unlink($gambar_path);
                        }
                    }
                    $file_k = $this->post('file_ktp_image');
                    write_file('./assets/image/ktp/' . $file_k, base64_decode($this->post('ktp_image')));
                    $updateData['ktp_image'] = $file_k;
                }

                $this->db->where('id', $id)->update('st_user', $updateData);

                $this->response([
                    'status' => 1,
                    'message' => 'Berhasil melakukan update profile !'
                ], RestController::HTTP_OK);
            }
        }
    }

    public function update_password_post()
    {
        $id = (int)$this->input->post('id');
        $password = $this->input->post('password');

        try {
            $this->db->where('id', $id)
                ->update('st_user', ['password' => $password]);

            $response = [
                'status' => 1,
                'message' => 'Berhasil melakukan update password!'
            ];
        } catch (Exception $e) {
            $response = [
                'status' => 0,
                'message' => 'Gagal melakukan update password!'
            ];
        }

        $this->response($response, RestController::HTTP_OK);
    }

    public function get_tolak_transaksi_get($id)
    {
        $data = $this->db->select('t.id, t.status, t.total_harga, t.id_user')
            ->from('transaksi as t')
            ->join('st_user as s', 's.id = t.id_mitra', 'left')
            ->where('t.id_user', $id)
            ->where('t.is_deleted', '1')
            ->where('t.status', 'tolak')
            ->get()
            ->result();

        $transactionsDetails = [];

        foreach ($data as $transaction) {
            $detail = $this->db->select('t.id, su.name as nama_mitra, t.status, p.image, p.nama_produk, dt.id_transaksi, dt.jumlah, p.harga, dt.sub_total as sub_harga, t.total_harga as total_all_produk')
                ->from('detail_transaksi as dt')
                ->join('product as p', 'p.id = dt.id_produk', 'left')
                ->join('transaksi as t', 't.id = dt.id_transaksi', 'left')
                ->join('st_user as su', 'su.id = p.id_mitra', 'left')
                ->where('dt.id_transaksi', $transaction->id)
                ->limit(1)
                ->get()
                ->row();

            $jumlah_all = $this->db->select_sum('jumlah')
                ->from('detail_transaksi')
                ->where('id_transaksi', $transaction->id)
                ->get()
                ->row()
                ->jumlah;

            if ($detail) {
                $detail->jumlah_all_produk = (int)$jumlah_all;
                $namaGambar = $detail->image;
                $gambarUrl = base_url('assets/image/produk/' . $namaGambar);
                $detail->image = $gambarUrl;

                $transactionsDetails[] = $detail;
            }
        }

        $this->response($transactionsDetails, RestController::HTTP_OK);
    }
}
