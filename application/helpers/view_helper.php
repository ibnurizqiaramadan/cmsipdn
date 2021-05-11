<?php

use Jenssegers\Blade\Blade;

if (!function_exists('view')) {
    function view($view, $data = [])
    {
        $path = APPPATH;
        $blade = new Blade($path.'views', $path . 'cache/views');
        echo preg_replace('!\s+!', ' ', $blade->make($view, $data));
    }
}