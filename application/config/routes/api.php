<?php

session_start();

$apiPath = API_PATH;

$path = explode("/", $_SERVER['REQUEST_URI']);

// $_SESSION['TOKEN'] = "123";

if ($path[1] == $apiPath) {
    error_reporting(0);
    if (isset($_SESSION['token'])) {
        if ($_SESSION['token'] != $_REQUEST['_token']) {
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
    "$apiPath/data/category"    => 'admin/C_Category/data',
    "$apiPath/data/news"        => 'admin/C_news/data',
]);

// get data options
$route = array_merge($route, [
    "$apiPath/data/options"           => 'admin/C_api/getDataOption',
    "$apiPath/data/options/(:any)"    => 'admin/C_api/getDataOption/$1',
]);

//get row data
$route = array_merge($route, [
    "$apiPath/data/users/get/(:any)"  => 'admin/C_users/getData/$1',
]);