<?php

class C_dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin/dashboard/vDashboard');
    }
}
