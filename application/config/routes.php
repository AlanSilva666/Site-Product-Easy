<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
// $route['preencher-campos-login'] = 'login/preencher_campos_login';
// $route['default_controller'] = 'welcome';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;
// $route['default_controller'] = 'login';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;
// $route['login'] = 'login/index';
// $route['home'] = 'home/index';

// $route['default_controller'] = 'login';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;
// $route['login'] = 'login/index';
// $route['login/process_login'] = 'login/process_login';
// $route['login/logout'] = 'login/logout';
// $route['home'] = 'home/index';
// $route['home/request_c'] = 'home/request_c';
// $route['home/edit_request/(:num)/(:num)'] = 'home/edit_request/$1/$2';
// $route['home/update_request/(:num)/(:num)'] = 'home/update_request/$1/$2';
// $route['home/cancel_request/(:num)/(:num)'] = 'home/cancel_request/$1/$2';
// $route['home/del_request/(:num)/(:num)'] = 'home/del_request/$1/$2';
// $route['home/fale_conosco'] = 'home/fale_conosco';
// $route['home/listar_pedidos'] = 'home/listar_pedidos';
// $route['home/listar_pedidos/(:any)'] = 'home/listar_pedidos/$1';
// $route['home/converter_arquivo/(:any)'] = 'home/converter_arquivo/$1';
// $route['home/processar_conversao_arquivo/(:any)'] = 'home/processar_conversao_arquivo/$1';

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'login/index';
$route['login/process_login'] = 'login/process_login';
$route['login/logout'] = 'login/logout';

$route['home'] = 'home/index';
$route['home/request_c'] = 'home/request_c';
$route['home/edit_request/(:num)/(:num)'] = 'home/edit_request/$1/$2';
$route['home/update_request/(:num)/(:num)'] = 'home/update_request/$1/$2';
$route['home/cancel_request/(:num)/(:num)'] = 'home/cancel_request/$1/$2';
$route['home/del_request/(:num)/(:num)'] = 'home/del_request/$1/$2';
$route['home/fale_conosco'] = 'home/fale_conosco';
$route['home/listar_pedidos'] = 'home/listar_pedidos';
$route['home/listar_pedidos/(:any)'] = 'home/listar_pedidos/$1';
$route['home/converter_arquivo/(:any)'] = 'home/converter_arquivo/$1';
$route['home/processar_conversao_arquivo/(:any)'] = 'home/processar_conversao_arquivo/$1';
$route['home/google_glass/(:num)'] = 'home/google_glass/$1';





