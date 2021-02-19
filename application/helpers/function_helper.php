<?php

function Create($table, $data, $json = false)
{
    try {

        $CI = &get_instance();
        $data = array_merge($data, [
            'created_at' => DATE_NOW,
            'updated_at' => DATE_NOW
        ]);
        $CI->db->insert($table, $data);
        $return_ = $CI->req->cekPerubahan();
        if ($return_ == false) throw new Exception("Gagal memasukan data");

        $message = [
            'status' => 'ok',
            'message' => 'Berhasil memasukan data'
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
        if ($json == true) {
            echo json_encode($message);
        } else {
            return $return_;
        }
    }
}

function Update($table, $data, $where, $json = false)
{
    try {

        $CI = &get_instance();
        $data = array_merge($data, [
            'updated_at' => DATE_NOW
        ]);
        $CI->db->where($where);
        $tampungGetData = $CI->db->get($table)->row_array();
        // $CI->req->query();
        $cekEdit = 0;
        foreach ($data as $key => $value) {
            // echo $value . " | ";
            if ($tampungGetData[$key] != $value) $cekEdit++;
            // echo "(" . $tampungGetData[$key] . " | " . $value . ") = " . $cekEdit . " || ";
        }
        if ($cekEdit <= 1) return false;
        $CI->db->where($where);
        $CI->db->update($table, $data);
        $return_ = $CI->req->cekPerubahan();
        if ($return_ == false) throw new Exception("Gagal mengupdate data");

        $message = [
            'status' => 'ok',
            'message' => 'Berhasil mengupdate data'
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
        if ($json == true) {
            echo json_encode($message);
        } else {
            return $return_;
        }
    }
}

function Delete($table, $where, $json = false)
{
    try {

        $CI = &get_instance();
        $CI->db->where($where);
        $CI->db->delete($table);
        $return_ = $CI->req->cekPerubahan();
        if ($return_ == false) throw new Exception("Gagal menghapus data");

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
        if ($json == true) {
            echo json_encode($message);
        } else {
            return $return_;
        }
    }
}

function Validate($data, $guarded = [])
{
    $validate = [
        'required' => '$key harus diisi',
        'min'      => '$key harus diisi setidaknya $n karakter',
        'max'      => '$key tidak boleh diisi lebih dari $n karakter',
        'number'   => '$key harus diisi oleh angka',
        'string'   => '$key harus diisi oleh huruf',
        'email'    => '$key harus diisi oleh Email yang benar',
        'name'     => '$key hanya boleh diisi oleh huruf dan spasi',
        'username' => '$key hanya boleh diisi oleh huruf dan nomor',
        'password' => '$key harus mengandung karakter, angka, simbol dan huruf besar',
        'sameas'   => '$key tidak sama dengan $target'
    ];
    $error = [];
    $errorCount = 0;
    foreach ($data as $key => $request) {
        $req = explode("|", $request);
        foreach ($req as $request_) {
            if ($request_ == 'required') {
                if (!isset($_REQUEST[$key]) || trim($_REQUEST[$key]) == "") {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => false,
                        'message' => str_replace('$key', $key, $validate[$request_]),
                    ];
                    $errorCount++;
                    break;
                } else {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => true,
                    ];
                }
            }
            if (substr($request_, 0, 3) == 'min') {
                $param = explode(":", $request_);
                if (!isset($_REQUEST[$key]) || strlen($_REQUEST[$key]) < $param[1]) {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => false,
                        'message' => str_replace(['$key', '$n'], [$key, $param[1]], $validate[$param[0]]),
                    ];
                    $errorCount++;
                    break;
                } else {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => true,
                    ];
                }
            }
            if (substr($request_, 0, 3) == 'max') {
                $param = explode(":", $request_);
                if (!isset($_REQUEST[$key]) || strlen($_REQUEST[$key]) > $param[1]) {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => false,
                        'message' => str_replace(['$key', '$n'], [$key, $param[1]], $validate[$param[0]]),
                    ];
                    $errorCount++;
                    break;
                } else {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => true,
                    ];
                }
            }
            if ($request_ == 'string') {
                if (preg_match('/[^A-Za-z ]/', $_REQUEST[$key])) {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => false,
                        'message' => str_replace(['$key'], $key, $validate[$request_]),
                    ];
                    $errorCount++;
                    break;
                } else {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => true,
                    ];
                }
            }
            if ($request_ == 'number') {
                if (preg_match('/[^0-9]/', $_REQUEST[$key])) {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => false,
                        'message' => str_replace(['$key'], $key, $validate[$request_]),
                    ];
                    $errorCount++;
                    break;
                } else {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => true,
                    ];
                }
            }
            if ($request_ == 'name') {
                if (!preg_match("/^[a-zA-Z-' ]*$/", $_REQUEST[$key])) {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => false,
                        'message' => str_replace(['$key'], $key, $validate[$request_]),
                    ];
                    $errorCount++;
                    break;
                } else {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => true,
                    ];
                }
            }
            if ($request_ == 'username') {
                if (!preg_match("/^[a-zA-Z-0-9']*$/", $_REQUEST[$key])) {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => false,
                        'message' => str_replace(['$key'], $key, $validate[$request_]),
                    ];
                    $errorCount++;
                    break;
                } else {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => true,
                    ];
                }
            }
            if ($request_ == 'email') {
                if (!filter_var($_REQUEST[$key], FILTER_VALIDATE_EMAIL)) {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => false,
                        'message' => str_replace('$key', $key, $validate[$request_])
                    ];
                    $errorCount++;
                    break;
                } else {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => true,
                    ];
                }
            }
            if ($request_ == 'password') {
                if (
                    !preg_match('/[\'^£$%&*()}{@#~?!><>,|=_+¬-]/', $_REQUEST[$key])
                    || !preg_match('/[0-9 ]/', $_REQUEST[$key])
                    || !preg_match('/[A-Z ]/', $_REQUEST[$key])
                ) {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => false,
                        'message' => str_replace('$key', $key, $validate[$request_])
                    ];
                    $errorCount++;
                    break;
                } else {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => true,
                    ];
                }
            }
            if (substr($request_, 0, 6) == 'sameas') {
                $param = explode(":", $request_);
                if (!isset($_REQUEST[$key]) || $_REQUEST[$key] != $_REQUEST[$param[1]]) {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => false,
                        'message' => str_replace(['$key', '$target'], [$key, $param[1]], $validate[$param[0]]),
                    ];
                    $errorCount++;
                    break;
                } else {
                    $error[$key] = [
                        'input'   => $key,
                        'type'    => $request_,
                        'valid'   => true,
                    ];
                }
            }
        }
    }
    if ($errorCount > 0) {
        return [
            'input' => $error,
            'success' => false
        ];
    } else {
        $request = $_SERVER['REQUEST_METHOD'] == "POST" ? $_POST : $_GET;
        unset($request['_token']);
        foreach ($request as $key => $value) {
            $result[$key] = Input_($key);
        }
        if ($guarded != null) {
            foreach ($guarded as $guard_ => $value) {
                if ($value == false) {
                    unset($result[$guard_]);
                } else {
                    unset($result[$guard_]);
                    $result[$guard_] = $value;
                }
            }
        }
        return [
            'success' => true,
            'input' => $error,
            'data' => $result,
        ];
    }
}

function ValidateAdd($validate, $input, $message)
{
    $validate['success'] = false;
    $valid = $validate['input'];
    $valid[$input] = ['input' => $input, 'message' => $message, 'valid' => false];
    $validate['input'] = $valid;
    return $validate;
}

function Guard($data, $guard)
{
    $CI = &get_instance();
    $result = $data;
    // foreach ($guard as $key) {
    //     unset($result[$key]);
    // }
    foreach ($guard as $protect) {
        $param = explode(":", $protect);
        if (count($param) > 1) {
            if ($param[1] == "hash") {
                $result[$param[0]] = $CI->req->acak($result[$param[0]]);
            }
        } else {
            unset($result[$protect]);
        }
    }
    return $result;
}

function Input_($input, $escape = false)
{
    $CI = &get_instance();
    return $escape == false ? trim(rtrim($_REQUEST[$input])) : ltrim(rtrim($CI->db->escape_str($_REQUEST[$input])));
}

function InputTags($input)
{
    return htmlspecialchars(trim(rtrim($_REQUEST[$input])));
}

function iLove($someone)
{
    return "i love u $someone 💖";
}
