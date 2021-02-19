<?php

session_start();

$adminPath = ADMIN_PATH;

$path = explode("/", $_SERVER['REQUEST_URI']);

if ($path[1] == $adminPath) {
    if (!isset($_SESSION['token'])) {
        error_reporting(0);
        if ($path[2] != 'login') {
            echo "<meta http-equiv='refresh' content='0;url=" . BASE_URL . ADMIN_PATH . "/login'/>";
            exit(0);
        }
    } else {
        error_reporting(0);
        if ($_SERVER['REQUEST_METHOD'] == "POST" && $path[2] != "login") {
            if ($_SESSION['token'] != $_REQUEST['_token']) {
                echo json_encode([
                    'status' => 'fail',
                    'smg' => 'invalid token'
                ]);
                exit(0);
            }
        }
        if (!$_SESSION['level'] == 1) {
            echo "<meta http-equiv='refresh' content='0;url=" . BASE_URL . "home'/>";
            exit(0);
        } 
    }
}

$route["$adminPath/login"] = 'C_login';
$route["$adminPath/login/action"] = 'C_login/action';
$route["$adminPath/login/destroy"] = 'C_login/logout';
$route["$adminPath"] = 'admin/C_dashboard';
$route["$adminPath/dashboard"] = 'admin/C_dashboard';

// users route
$controller = "C_users";
$path = "users";
$route = array_merge($route, [
    "$adminPath/$path"                   => "admin/$controller",
    "$adminPath/$path/store"             => "admin/$controller/store",
    "$adminPath/$path/delete"            => "admin/$controller/delete",
    "$adminPath/$path/update"            => "admin/$controller/update",
    "$adminPath/$path/reset/(:any)"      => "admin/$controller/reset/$1",
    "$adminPath/$path/set/(:any)"        => "admin/$controller/set_/$1",
    "$adminPath/$path/delete-multiple"   => "admin/$controller/deleteMultiple",
    "$adminPath/$path/reset-multiple"    => "admin/$controller/resetMultiple",
    "$adminPath/$path/set-multiple"      => "admin/$controller/setMultiple",
]);

// category route
$controller = "C_category";
$path = "category";
$route = array_merge($route, [
    "$adminPath/$path"                   => "admin/$controller",
    "$adminPath/$path/store"             => "admin/$controller/store",
    "$adminPath/$path/delete"            => "admin/$controller/delete",
    "$adminPath/$path/update"            => "admin/$controller/update",
]);

// news route
$controller = "C_news";
$path = "news";
$route = array_merge($route, [
    "$adminPath/$path"                   => "admin/$controller",
    "$adminPath/$path/store"             => "admin/$controller/store",
    "$adminPath/$path/delete"            => "admin/$controller/delete",
    "$adminPath/$path/update"            => "admin/$controller/update",
    "$adminPath/$path/set"               => "admin/$controller/set",
]);

