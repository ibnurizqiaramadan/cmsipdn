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

    public function getData($id)
    {
        try {
            
            $data = $this->db->get_where($this->table, [$this->req->encKey('id') => $id])->row_array();
            if (!$data) throw new Exception("no data");
            $data = Guard($data, ["id:hash", "token", "password"]);
            $message = [
                'status' => 'ok',
                'data' => $data
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

    public function store()
    {
        try {
            $validate = Validate([
                'username' => 'required|min:6|max:20|username',
                'name' => 'required|min:6|name',
                'role' => 'required|number'
            ], ['password' => $this->req->acak('123456')]);
            
            if (!$validate['success']) throw new Exception("Error Processing Request");
            if (!Create($this->table, Guard($validate['data'], ['id', 'token']))) throw new Exception("Gagal memasukan data !");
            
            $message = [
                'status' => 'ok',
                'validate' => $validate,
                'message' => "Berhasil memasukan data"
            ];

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

    public function update()
    {
        try {
            $validate = Validate([
                'id' => 'required',
                'username' => 'required|min:6|max:20|username',
                'name' => 'required|min:6|name',
                'role' => 'required|number'
            ]);

            if (!$validate['success']) throw new Exception("Error Processing Request");
            if (!Update($this->table, Guard($validate['data'], ['id', 'token']), [$this->req->encKey('id') => Input_('id')])) throw new Exception("Tidak ada perubahan");

            $message = [
                'status' => 'ok',
                'validate' => $validate,
                'message' => "Berhasil merubah data"
            ];
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
            $message = array_merge($message, ['modalClose' => true]);
            echo json_encode($message);
        }
    }

    public function reset($id = '')
    {
        try {
            
            if ($id == '') throw new Exception("no param");
            
            if (Update($this->table, ['password' => $this->req->acak("123456")], [$this->req->encKey('id') => $id]) == false) throw new Exception("Gagal mereset password");

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

    public function deleteMultiple()
    {
        try {

            if (!isset($_POST['dataId'])) throw new Exception("no param");

            $dataId = explode(",", Input_('dataId'));

            $jmlSukses = 0;
            foreach ($dataId as $key) {
                if (Delete($this->table, [$this->req->encKey('id') => $key])) $jmlSukses++;
            }

            $message = [
                'status' => 'ok',
                'message' => "Berhasil menghapus <b>$jmlSukses</b> data dari <b>" . count($dataId) . "</b> data"
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

    public function resetMultiple()
    {
        try {

            if (!isset($_POST['dataId'])) throw new Exception("no param");

            $dataId = explode(",", Input_('dataId'));

            $jmlSukses = 0;
            foreach ($dataId as $key) {
                if (Update($this->table, ['password' => $this->req->acak("123456")], [$this->req->encKey('id') => $key])) $jmlSukses++;
            }

            $message = [
                'status' => 'ok',
                'message' => "Berhasil mereset <b>$jmlSukses</b> data dari <b>" . count($dataId) . "</b> data"
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

    public function setMultiple()
    {
        try {

            if (!isset($_POST['dataId'])) throw new Exception("no param");
            if (!isset($_POST['action'])) throw new Exception("missing param");

            $dataId = explode(",", Input_('dataId'));
            $status = Input_('action') == 'active' ? '1' : '0';
            $jmlSukses = 0;

            foreach ($dataId as $key) {
                if (Update($this->table, ['active' => $status], [$this->req->encKey('id') => $key])) $jmlSukses++;
            }

            $message = [
                'status' => 'ok',
                'message' => "Berhasil merubah status <b>$jmlSukses</b> data dari <b>" . count($dataId) . "</b> data"
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
