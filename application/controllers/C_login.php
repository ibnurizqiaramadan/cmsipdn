<?php

class C_login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (isset($_SESSION['TOKEN'])) {
            redirect(base_url(ADMIN_PATH));
        }
    }

    public function index()
    {
        return view('admin/vLogin');
    }

    public function action()
    {
        $where = [
            'username' => $this->req->input('username'),
            'password' => $this->req->acak($this->req->input('password'))
        ];
        $users = $this->db->get_where('t_users', $where);
        if ($users->num_rows() == 1) {
            $userData = $users->row();
            if ($userData->active == 1) {
                $session = [
                    'username' => $userData->username,
                    'name' => $userData->name,
                    'level' => $userData->role, // 0 = User; 1 = Admin
                    'token' => $this->req->acak(time() . $userData->token . $userData->username)
                ];
                echo json_encode([
                    'status' => 'ok',
                    'msg' => "Sukes"
                ]);   
            } else {
                echo json_encode([
                    'status' => 'fail',
                    'msg' => "Akun Anda tidak aktif"
                ]);   
            }
        }
    }
}
