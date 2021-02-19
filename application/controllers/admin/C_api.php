<?php

class C_api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function getDataOption($data = '')
    {
        try {
            if ($data == '') throw new Exception("no param");
            $table = [
                'users'     => [
                    'table'     => 't_users',
                    'protected' => ['id:hash', 'password', 'token']
                ],
                'category'  => [
                    'table'     => 't_category',
                    'protected' => ['id:hash']
                ],
            ];
            if (!$table[$data]) throw new Exception("nothing there");
            if (isset($_REQUEST['where'])) $this->db->where($_REQUEST['where']);
            if (isset($_REQUEST['order'])) $this->db->order_by(key($_REQUEST['order']), $_REQUEST['order'][key($_REQUEST['order'])]);
            $data_ = $this->db->get($table[$data])->result_array();
            $resultData = [];
            foreach ($data_ as $rows) {
                foreach ($table[$data]['protected'] as $protect) {
                    $param = explode(":", $protect);
                    if (count($param) > 1) {
                        if ($param[1] == "hash") {
                            $rows[$param[0]] = $this->req->acak($rows[$param[0]]);
                        }
                    } else {
                        unset($rows[$protect]);
                    }
                }
                unset($rows['created_at']);
                $resultData[]  = $rows;
            }
            $message = [
                'status' => 'ok',
                'data' => $resultData
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
