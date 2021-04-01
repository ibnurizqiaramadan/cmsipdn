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
        try {
            if (!isPost()) throw new Exception("Bad Request");
            $this->news->table = $this->table . " as news";
            $this->news->columnOrder = [null, 'title', 'u.name', null, 'news.updated_at', null, 'news.status'];
            $this->news->columnSearch = ['news.title', 'news.slug'];
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
                news.status,
                (SELECT CONCAT('[', GROUP_CONCAT(CONCAT('\"'," . $this->req->encKey('cat.id') . ",':',cat.name,'\"') SEPARATOR ','), ']' ) FROM t_news_category ncat JOIN t_category cat ON cat.id = ncat.category_id WHERE ncat.news_id = news.id) as category
            ";
            $field = ['title', 'slug', 'cover', 'author', 'category', 'created_at', 'updated_at', 'status'];
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
        } catch (\Throwable $th) {
            $output = [
                'status' => 'fail',
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $output = [
                'status' => 'fail',
                'message' => $ex->getMessage()
            ];
        } finally {
            echo json_encode($output);
        }
    }

    public function checkTitle()
    {
        try {
            if (!isPost()) throw new Exception("Bad Request");
            if (!isset($_POST['title'])) throw new Exception("Error Processing Request");
            $validate = Validate([
                'title' => 'requred|min:6'
            ]);
            $surat = $this->db->select('title')->from('t_news')->where('title', Input_('title'))->get()->row();
            if ($surat) $validate = ValidateAdd($validate, 'title', 'Judul sudah digunakan');

            $message = [
                'status' => 'ok',
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
            $message = array_merge($message, $validate);
            echo json_encode($message);
        }
    }

    public function store()
    {
        try {
            $validate = Validate([
                'title' => 'required|min:6',
                'category' => 'required',
                'content' => 'required'
            ], [
                'user_id' => $this->session->userId,
                'update_by' => $this->session->userId,
                'slug' => str_replace(" ", "-", Input_('title')),
                'category' => false
            ]);

            if (!$validate['success']) throw new Exception("Error Processing Request");
            if (!Create($this->table, $validate['data'])) throw new Exception("Gagal memasukan data !");
            $idNews = $this->db->insert_id();
            $newsCategory = json_decode(Input_('category'))??[];
            foreach ($newsCategory as $cat) {
                $categoryId = $this->db->select('id')->from('t_category')->where($this->req->encKey('id'), $cat)->get()->row()->id;
                $dataCategory[] = [
                    'news_id' => $idNews,
                    'category_id' => $categoryId
                ];
            }
            CreateMultiple('t_news_category', $dataCategory);
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
            $message = array_merge($message, ['validate' => $validate]);
            echo json_encode($message);
        }
    }

    public function update()
    {
        try {
            $validate = Validate([
                'title' => 'required|min:6',
                'category' => 'required',
                'content' => 'required'
            ], [
                'update_by' => $this->session->userId,
                'category' => false
            ]);
            if (!$validate['success']) throw new Exception("Error Processing Request");
            $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
            $news = $this->db->select('id')->from($this->table)->where($this->req->id(Input_('id')))->get()->row();
            if (!$news) throw new Exception("no data");
            Delete("t_news_category", ['news_id' => $news->id]);
            $newsCategory = json_decode(Input_('category')) ?? [];
            foreach ($newsCategory as $cat) {
                $categoryId = $this->db->select('id')->from('t_category')->where($this->req->encKey('id'), $cat)->get()->row()->id;
                $dataCategory[] = [
                    'news_id' => $news->id,
                    'category_id' => $categoryId
                ];
            }
            $addCategory = CreateMultiple('t_news_category', $dataCategory);
            if (!Update($this->table, $validate['data'], $this->req->id(Input_('id'))) && !$addCategory) throw new Exception("Tidak ada perubahan");
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

    public function set_($id = '')
    {
        try {

            if ($id == '') throw new Exception("no param");

            $status = $this->req->input('status') == "on" ? '1' : '0';

            if (Update($this->table, ['status' => $status], [$this->req->encKey('id') => $id]) == false) throw new Exception("Gagal merubah status");

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
                'message' => "Berhasil menghapus <br>$jmlSukses</br> data dari <b>" . count($dataId) . "</b> data"
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
                if (Update($this->table, ['status' => $status], [$this->req->encKey('id') => $key])) $jmlSukses++;
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

    public function getData($id)
    {
        try {
            $data = $this->db->select("n.id, n.title, n.content, (SELECT CONCAT('[',GROUP_CONCAT(CONCAT('\"'," . $this->req->encKey('category_id') . ",'\"')), ']') FROM t_news_category WHERE news_id = n.id) as category")
                ->from('t_news n')
                ->where($this->req->encKey('id'), $id)
                ->get()->row_array();
            $data = Guard($data, ["id:hash"]);
            if (!$data) throw new Exception("no data");
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
}
