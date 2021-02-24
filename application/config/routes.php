<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$path = explode("/", $_SERVER['REQUEST_URI']);
// echo json_encode($_SERVER);
// echo $_SERVER['REQUEST_URI'];
// // echo print_r($path);
// echo DOCUMENT_ROOT;
// exit();

require_once 'routes/home.php';

$pathCek = $path[1] == APP_FOLDER ? $path[2] : $path[1];

if ($pathCek == API_PATH) {
    require_once 'routes/api.php';
}

if ($pathCek == ADMIN_PATH) {
    require_once 'routes/admin.php';
}
