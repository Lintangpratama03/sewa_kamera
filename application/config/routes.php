<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Auth_user';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['profile'] = 'Front_page/profile';
$route['logout_1'] = 'Auth_user/logout';

//admin
$route['dashboard'] = 'Dashboard_admin';
$route['manage-pelanggan-daftar'] = 'Manage_user_admin';
$route['manage-pelanggan-aktif'] = 'Manage_user_aktif_admin';
$route['manage-kategori'] = 'Manage_category';
$route['verifikasi-produk'] = 'Verifikasi_product';
$route['manage-mitra-daftar'] = 'Manage_mitra_admin';
$route['manage-mitra-aktif'] = 'Manage_mitra_aktif_admin';
$route['admin'] = 'Admin';
$route['logout'] = 'Admin/logout';
$route['data-sewa'] = 'data-admin/Data_sewa';
$route['manage-pemasukan'] = 'Manage_pemasukan';
$route['manage-pemasukan-detail/(:num)/(:num)'] = 'Manage_pemasukan_detail/index/$1/$2';


// mitra
$route['mitra'] = 'Auth_user';
$route['dashboard-mitra'] = 'Dashboard_mitra';
$route['registrasi'] = 'Auth_user/register';

$route['profil-mitra'] = 'Manage_mitra';

$route['manage-product'] = 'Manage_product';
$route['manage-ulasan'] = 'Manage_ulasan';

$route['manage-transaksi'] = 'Manage_transaksi';
$route['manage-history'] = 'Manage_history_transaksi';

$route['manage-kembali'] = 'Manage_kembali';
$route['history-kembali'] = 'Manage_history_kembali';

$route['manage-kembali/(:num)'] = 'Manage_kembali_detail/index/$1';
$route['history-kembali/(:num)'] = 'Manage_history_kembali_detail/index/$1';

$route['manage-ulasan-detail/(:num)'] = 'Manage_ulasan_detail/index/$1';

// API
$route['get_user'] = 'api/Manage_all/index';
$route['login'] = 'api/Manage_all/login';
$route['get_produk'] = 'api/Manage_all/produk';
$route['get_produk_terbaru'] = 'api/Manage_all/produk_terbaru';
$route['get_category'] = 'api/Manage_all/get_category';
$route['get_detail_produk/(:num)'] = 'api/Manage_all/get_detail_produk/$1';
$route['insert_keranjang'] = 'api/Manage_all/insert_keranjang';
$route['get_keranjang/(:num)'] = 'api/Manage_all/get_keranjang/$1';
$route['delete_keranjang/(:num)'] = 'api/Manage_all/delete_keranjang_delete/$1';
$route['update_qty_keranjang/(:num)'] = 'api/Manage_all/update_qty_keranjang/$1';
$route['get_mitra'] = 'api/Manage_all/get_mitra';
$route['create_transaksi_booking'] = 'api/Manage_all/create_transaksi_booking';
$route['get_booking_transaksi/(:num)'] = 'api/Manage_all/get_booking_transaksi/$1';
$route['get_terverifikasi_transaksi/(:num)'] = 'api/Manage_all/get_terverifikasi_transaksi/$1';
$route['charge'] = 'api/Manage_all/charge';
$route['get_detail_transaksi_bayar'] = 'api/Manage_all/get_detail_transaksi_bayar';
$route['get_update_transaksi_status'] = 'api/Manage_all/get_update_transaksi_status';
$route['get_update_status_expired'] = 'api/Manage_all/get_update_status_expired';
$route['register'] = 'api/Manage_all/register';
$route['get_dibayar_transaksi/(:num)'] = 'api/Manage_all/get_dibayar_transaksi/$1';
$route['get_cek_expired/(:num)'] = 'api/Manage_all/get_cek_expired/$1';
$route['get_lunas_transaksi/(:num)'] = 'api/Manage_all/get_lunas_transaksi/$1';
$route['get_dipinjam_transaksi/(:num)'] = 'api/Manage_all/get_dipinjam_transaksi/$1';
$route['get_selesai_transaksi/(:num)'] = 'api/Manage_all/get_selesai_transaksi/$1';
$route['get_expired_transaksi/(:num)'] = 'api/Manage_all/get_expired_transaksi/$1';
$route['get_detail_history'] = 'api/Manage_all/get_detail_history';
$route['get_produk_rating'] = 'api/Manage_all/get_produk_rating';
$route['create_data_rating'] = 'api/Manage_all/create_data_rating';
$route['get_rekomendasi_produk'] = 'api/Manage_all/get_rekomendasi_produk';
$route['get_detail_rating/(:num)'] = 'api/Manage_all/get_detail_rating/$1';
$route['get_detail_ulasan/(:num)'] = 'api/Manage_all/get_detail_ulasan/$1';
$route['get_profile/(:num)'] = 'api/Manage_all/get_profile/$1';
$route['update_profile'] = 'api/Manage_all/update_profile';
$route['update_password'] = 'api/Manage_all/update_password';
$route['get_list_produk'] = 'api/Manage_all/get_list_produk';
$route['get_category_spinner'] = 'api/Manage_all/get_category_spinner';
$route['get_detail_mitra/(:num)'] = 'api/Manage_all/get_detail_mitra/$1';
