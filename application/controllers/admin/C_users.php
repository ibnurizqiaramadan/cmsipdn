<?php

class C_users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin/users/vUserList');
    }
}
