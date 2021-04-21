<?php

class C_category extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->table = "t_category";
        $this->load->model('admin/Master_model', 'cat');
    }

    public function index()
    {
        return view('admin/category/vCategory');
    }

    public function data()
    {
        $this->cat->table = $this->table;
        $this->cat->columnOrder = [null, 'name', 'slug'];
        $this->cat->columnSearch = ['name', 'slug'];
        $field = ['name', 'slug'];
        $list = $this->cat->get_datatables();
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
            "recordsTotal" => $this->cat->count_all(),
            "recordsFiltered" => $this->cat->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function getData($id)
    {
        try {

            $data = $this->db->get_where($this->table, [$this->req->encKey('id') => $id])->row_array();
            if (!$data) throw new Exception("no data");
            $data = Guard($data, ["id:hash"]);
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
                'name' => 'required|min:3|name',
            ], [
                'slug' => str_replace(" ", '-', strtolower(Input_('name'))), 
                'user_id' => $this->session->userId    
            ]);
            $cat = $this->db->select('slug')->from($this->table)->where('slug', str_replace(" ", '-', strtolower(Input_('name'))))->get()->row();
            if ($cat) $validate = ValidateAdd($validate, 'name', 'Kategori sudah ada');
            if (!$validate['success']) throw new Exception("Error Processing Request");
            if (!Create($this->table, Guard($validate['data'], ['id', 'token']))) throw new Exception("Gagal memasukan data !");

            $message = [
                'status' => 'ok',
                'message' => "Berhasil memasukan data"
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
            $message = array_merge($message, ['validate' => $validate,'validate' => $validate]);
            echo json_encode($message);
        }
    }

    public function update()
    {
        try {
            $validate = Validate([
                'name' => 'required|min:3|name',
            ]);
            $cat = $this->db->select('slug')->from($this->table)->where('slug', str_replace(" ", '-', strtolower(Input_('name'))))->get()->row();
            if ($cat) $validate = ValidateAdd($validate, 'name', 'Kategori sudah ada');
            if (!$validate['success']) throw new Exception("Error Processing Request");
            if (!Update($this->table, Guard($validate['data'], ['id', 'token', 'password', 'active']), [$this->req->encKey('id') => Input_('id')])) throw new Exception("Tidak ada perubahan");

            $message = [
                'status' => 'ok',
                'message' => "Berhasil merubah data"
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
            $message = array_merge($message, ['validate' => $validate, 'modalClose' => true]);
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
}
