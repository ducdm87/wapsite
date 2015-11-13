<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

$route['default_controller'] = "client/home";
$route['404_override'] = 'client/error_404';

$route['acp_admin'] = 'admin/home';
$route['acp_admin/(:any)?'] = 'admin/$1';

//$route["lien-he-quan-tri.html"] = "client/html/contact";
$route["thanh-vien-vip.html"] = "client/html/vip";
$route["dang-nhap.html"] = "client/user/login";
$route["dang-nhap-app.html"] = "client/user/login2";
$route["dang-xuat.html"] = "client/user/logout";
$route["cap-nhat-thong-tin-ca-nhan.html"] = "client/user/update_info";
$route["cap-nhat-thong-tin-ca-nhan-app.html"] = "client/user/update_info2";
$route["quay-so-may-man.html"] = "client/quayxs";
$route["quay-thu.html"] = "client/quayxs/quaythu";
$route["cung-quay-xo-so.html"] = "client/quayxs/quaynhanh";
$route["tuong-thuat-truc-tiep-ket-qua-xo-so.html"] = "client/tructiep/index/home";
$route["ket-qua.html"] = "client/xoso/home";
$route["ket-qua/([\d]+-[\d]+-[\d]+).html"] = "client/xoso/home/$1";

$route['xo-so-dien-toan.html'] = 'client/xs_northern/index';
$route['xo-so-dien-toan/([\d]+-[\d]+-[\d]+).html'] = 'client/xs_northern/byday/$1';
$route['xo-so-dien-toan/(.*?)/([\d]+-[\d]+-[\d]+).html'] = 'client/xs_northern/bytype/$1/$2';

$route['openid/(.*)'] = 'client/user/openid/$1';

$route['([A-Za-z0-9_-]+)-xo-so-mien-bac.html'] = 'client/error_404';

$route['admin(:any)?'] = 'client/error_404';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
