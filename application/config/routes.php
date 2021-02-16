<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$path = explode("/", $_SERVER['REQUEST_URI']);

require_once 'routes/home.php';

if ($path[1] == API_PATH) {
    require_once 'routes/api.php';
}

if ($path[1] == ADMIN_PATH) {
    require_once 'routes/admin.php';
}
