<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin/layouts/app', ['title' => 'Dashboard']);
    }
}
