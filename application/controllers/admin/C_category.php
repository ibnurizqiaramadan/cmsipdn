<?php

class C_category extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Master_model', 'cat');
    }

    public function index()
    {
        return View('admin.category.vCategory');
    }

    public function data()
    {
        $list = $this->cat->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $idNa = $this->req->acak($field->id);
            $no++;
            $row = array();
            $row['id'] = $idNa;
            $row['name'] = $field->name;
            $row['slug'] = $field->slug;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cat->count_all(),
            "recordsFiltered" => $this->cat->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
}
