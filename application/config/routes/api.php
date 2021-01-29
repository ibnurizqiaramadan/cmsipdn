<?php

$apiPath = API_PATH;

$path = explode("/", $_SERVER['REQUEST_URI']);

// $_SESSION['TOKEN'] = "123";

if ($path[1] == $apiPath) {
    error_reporting(0);
    if (isset($_SESSION['TOKEN'])) {
        if ($_SESSION['TOKEN'] != $_REQUEST['_token']) {
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
    }
}

$route["$apiPath/home/news/list"] = 'api/ApiHome';