<?php

class C_login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_SESSION['token'])) {
            redirect(base_url(ADMIN_PATH));
        }
        return view('admin/vLogin');
    }

    public function action()
    {
        try {
        
            $validate = Validate([
                'username' => 'required|min:5|username',
                'password' => 'required'
            ], [
                'password' => $this->req->acak(Input_('password'))
            ]);
            if ($validate['success']) {
                $users = $this->db->get_where('t_users', $validate['data']);
                if ($users->num_rows() <= 0) throw new Exception("Username atau Password salah");
                $userData = $users->row();
                if ($userData->active != 1) throw new Exception("Akun Anda tidak aktif");
                $token = $this->req->acak(time() . $userData->token . $userData->username);
                $session = [
                    'username' => $userData->username,
                    'name' => $userData->name,
                    'level' => $userData->role, // 0 = User; 1 = Admin
                    'token' => $token
                ];
                Update('t_users', ['token' => $token], ['id' => $userData->id]);
                $this->session->set_userdata($session);
                $message = [
                    'status' => 'ok',
                    'validate' => $validate,
                    'message' => "Selamat datang $session[name]"
                ];   
            } else {
                $message = [
                    'status' => 'fail',
                    'validate' => $validate,
                ];   
            }
        } catch (\Throwable $th) {
            $message = [
                'status' => 'fail',
                'validate' => $validate,
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $message = [
                'status' => 'fail',
                'validate' => $validate,
                'message' => $ex->getMessage()
            ];
        } finally {
            echo json_encode($message);
        }
    }

    public function logout()
    {
        try {
            $token = $this->input->post('_token');
            if (base64Enc($this->session->token, 3) != $token) throw new Exception("invalid token");

            $this->session->sess_destroy();

            $message = [
                'status' => 'ok',
                'message' => 'Session destroyed'
            ];

        } catch (\Exception $ex) {
            $message = [
                'status' => 'fail',
                'message' => $ex->getMessage()
            ];
        } catch (\Throwable $th) {
            echo json_decode([
                'status' => 'fail',
                'message' => $th->getMessage()
            ]);
        } finally {
            echo json_encode($message);
        }
    }
}
