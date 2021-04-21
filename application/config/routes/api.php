<?php

session_start();

$apiPath = API_PATH;

$path = explode("/", $_SERVER['REQUEST_URI']);

$pathCek = $path[1] == APP_FOLDER ? $path[2] : $path[1];
// $_SESSION['TOKEN'] = "123";

if ($pathCek == $apiPath) {
    error_reporting(0);
    if (isset($_SESSION['token'])) {
        if (base64Enc($_SESSION['token'], 3) != $_REQUEST['_token']) {
            echo json_encode([
                'status' => 'fail',
                'smg' => 'invalid token'
            ]);
            exit(0);
        }
    } else {
        echo json_encode([
            'status' => 'fail',
            'smg' => 'bad request'
        ]);
        exit(0);
    }
}

$route["$apiPath/home/news/list"] = 'api/ApiHome';

// get data tables
$route = array_merge($route, [
    "$apiPath/data/users"       => 'admin/C_users/data',
    "$apiPath/data/category"    => 'admin/C_category/data',
    "$apiPath/data/news"        => 'admin/C_news/data',
    "$apiPath/data/events"        => 'admin/C_events/data',
]);

// get data options
$route = array_merge($route, [
    "$apiPath/data/options"           => 'api/ApiAdmin/getDataOption',
    "$apiPath/data/options/(:any)"    => 'api/ApiAdmin/getDataOption/$1',
]);

//get row data
$route = array_merge($route, [
    "$apiPath/data/users/get/(:any)"     => 'admin/C_users/getData/$1',
    "$apiPath/data/category/get/(:any)"  => 'admin/C_category/getData/$1',
    "$apiPath/data/news/get/(:any)"  => 'admin/C_news/getData/$1',
]);