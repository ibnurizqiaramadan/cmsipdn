<?php

class C_news extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin/news/vNewsList');
    }
}
