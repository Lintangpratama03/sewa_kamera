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
$route['manage-mitra-daftar'] = 'Manage_mitra_admin';
$route['manage-mitra-aktif'] = 'Manage_mitra_aktif_admin';
$route['admin'] = 'Admin';
$route['logout'] = 'Admin/logout';


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

$route['manage-pemasukan'] = 'Manage_pemasukan';
$route['manage-pemasukan-detail/(:num)/(:num)'] = 'Manage_pemasukan_detail/index/$1/$2';

$route['data-sewa'] = 'data-admin/Data_sewa';
// api
$route['api/manage_product'] = 'api/Manage_product/index';
$route['api/manage_product/category'] = 'api/Manage_product/category';
$route['api/manage_product/product'] = 'api/Manage_product/product';
$route['api/manage_product/insert'] = 'api/Manage_product/insert';
$route['api/manage_product/update'] = 'api/Manage_product/update';
$route['api/manage_product/delete'] = 'api/Manage_product/delete';


$route['api/manage_all'] = 'api/Manage_all/index';
$route['api/manage_all/login'] = 'api/Manage_all/login';
$route['api/manage_all/produk'] = 'api/Manage_all/get_produk';
$route['api/manage_all/produk/terbaru'] = 'api/Manage_all/get_produk_terbaru';
$route['api/manage_all/produk/terlaris'] = 'api/Manage_all/get_produk_terlaris';
$route['api/manage_all/category'] = 'api/Manage_all/get_category';
$route['api/manage_all/produk/detail/(:num)'] = 'api/Manage_all/get_detail_produk/$1';
$route['api/manage_all/keranjang/insert'] = 'api/Manage_all/insert_keranjang';
$route['api/manage_all/keranjang'] = 'api/Manage_all/get_keranjang';
$route['api/manage_all/mitra'] = 'api/Manage_all/get_mitra';
$route['api/manage_all/keranjang/delete/(:num)'] = 'api/Manage_all/delete_keranjang/$1';
$route['api/manage_all/keranjang/update/(:num)'] = 'api/Manage_all/update_qty_keranjang/$1';
