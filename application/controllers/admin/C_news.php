<?php

class C_news extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->table = 't_news';
        $this->load->model('admin/Master_model', 'news');
    }

    public function index()
    {
        return view('admin/news/vNewsList');
    }

    public function data()
    {
        $this->news->table = $this->table . " as news";
        $this->news->columnOrder = [null, 'name', 'slug'];
        $this->news->columnSearch = ['name', 'slug'];
        $this->news->tableJoin = [
            't_users as u' => 'u.id = news.user_id'
        ];
        $this->news->selectData = "news.id,
            news.title, 
            news.slug, 
            news.cover, 
            u.name as author,
            news.created_at,
            news.updated_at,
            (SELECT CONCAT('[', GROUP_CONCAT(CONCAT('\"'," . $this->req->encKey('cat.id') . ",':',cat.name,'\"') SEPARATOR ','), ']' ) FROM t_news_category ncat JOIN t_category cat ON cat.id = ncat.category_id WHERE ncat.news_id = news.id) as category
        ";
        $field = ['title', 'slug', 'cover', 'author', 'category', 'created_at', 'updated_at'];
        $list = $this->news->get_datatables();
        $data = array();
        foreach ($list as $field_) {
            $row = array();
            $row['id'] = $this->req->acak($field_['id']);
            foreach ($field as $key) {
                $row[$key] = $field_[$key];
            }
            $data[] = $row;
        }
        $draw = isset($_POST['draw']) ? $_POST['draw'] : null;
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $this->news->count_all(),
            "recordsFiltered" => $this->news->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
}
