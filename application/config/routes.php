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
$route['manage-kategori'] = 'Manage_category';
$route['manage-ulasan'] = 'Manage_ulasan';

$route['manage-transaksi'] = 'Manage_transaksi';
$route['manage-history'] = 'Manage_history';
