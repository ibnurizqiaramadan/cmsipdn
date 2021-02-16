<?php

class C_users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->table = "t_users";
        $this->load->model('admin/Master_model', 'users');
    }

    public function index()
    {
        return view('admin/users/vUserList');
    }

    public function data()
    {
        $this->users->table = $this->table;
        $this->users->columnOrder = [null,'username', 'name', 'role', 'active'];
        $this->users->columnSearch = ['username', 'name', "role", "active"];
        $field = ['username', 'name', 'role', 'active'];
        $list = $this->users->get_datatables();
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
            "recordsTotal" => $this->users->count_all(),
            "recordsFiltered" => $this->users->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function reset($id = '')
    {
        try {
            
            if ($id == '') throw new Exception("no param");
            
            if (Update($this->table, ['password' => $this->req->acak("123")], [$this->req->encKey('id') => $id]) == false) throw new Exception("Gagal mereset password");

            $message = [
                'status' => 'ok',
                'message' => 'Berhasil mereset password'
            ];

        } catch (\Throwable $th) {
            $message = [
                'status' => 'fail',
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $message = [
                'status' => 'fail',
                'message' => $ex->getMessage()
            ];
        } finally {
            echo json_encode($message);
        }
    }

    public function set_($id = '')
    {
        try {

            if ($id == '') throw new Exception("no param");

            $status = $this->req->input('status') == "on" ? '1' : '0';

            if (Update($this->table, ['active' => $status], [$this->req->encKey('id') => $id]) == false) throw new Exception("Gagal merubah status");

            $message = [
                'status' => 'ok',
                'message' => 'Berhasil merubah status'
            ];
        } catch (\Throwable $th) {
            $message = [
                'status' => 'fail',
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $message = [
                'status' => 'fail',
                'message' => $ex->getMessage()
            ];
        } finally {
            echo json_encode($message);
        }
    }

    public function delete()
    {
        try {

            if (!isset($_POST['id'])) throw new Exception("no param");

            $id = $this->req->input('id');

            if (Delete($this->table, [$this->req->encKey('id') => $id]) == false) throw new Exception("Gagal menghapus data");

            $message = [
                'status' => 'ok',
                'message' => 'Berhasil menghapus data'
            ];  

        } catch (\Throwable $th) {
            $message = [
                'status' => 'fail',
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $message = [
                'status' => 'fail',
                'message' => $ex->getMessage()
            ];
        } finally {
            echo json_encode($message);
        }
    }
}
