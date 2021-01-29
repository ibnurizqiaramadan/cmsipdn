<?php

$adminPath = ADMIN_PATH;

$path = explode("/", $_SERVER['REQUEST_URI']);

// $_SESSION['TOKEN'] = '123';
// $_SESSION['LEVEL'] = '1';

if ($path[1] == $adminPath) {
    if (!isset($_SESSION['TOKEN'])) {
        error_reporting(0);
        if ($path[2] != 'login') {
            echo "<meta http-equiv='refresh' content='0;url=" . BASE_URL . ADMIN_PATH . "/login'/>";
            exit(0);
        }
    } else {
        error_reporting(0);
        if ($_SERVER['REQUEST_METHOD'] == "POST" && $path[2] != "login") {
            if ($_SESSION['TOKEN'] != $_REQUEST['_token']) {
                echo json_encode([
                    'status' => 'fail',
                    'smg' => 'invalid token'
                ]);
                exit(0);
            }
        }
        if (!$_SESSION['LEVEL'] == 1) {
            echo "<meta http-equiv='refresh' content='0;url=" . BASE_URL . "home'/>";
            exit(0);
        } 
    }
}

$route["$adminPath/login"] = 'C_login';
$route["$adminPath/login/action"] = 'C_login/action';
$route["$adminPath"] = 'admin/C_dashboard';
$route["$adminPath/dashboard"] = 'admin/C_dashboard';
$route["$adminPath/users"] = 'admin/C_users';
$route["$adminPath/news"] = 'admin/C_news';
