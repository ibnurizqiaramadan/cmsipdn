<?php

class Master_model extends CI_Model
{
    public $table = '';
    public $columnOrder = [];
    public $columnSearch = [];
    public $whereData = '';
    public $selectData = '';
    public $tableJoin = [];

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->table = $this->table;
        $this->column_order = $this->columnOrder;
        $this->column_search = $this->columnSearch;
        $this->order = ['id' => 'desc'];

        if ($this->selectData != '') {
            $this->db->select($this->selectData);
        }
        $this->db->from($this->table);

        if (!empty($this->tableJoin)) {
            foreach ($this->tableJoin as $key => $value) {
                $this->db->join($key, $value);
            }
        }

        $i = 0;

        foreach ($this->column_search as $item) {
            if (!isset($_REQUEST['search'])) {
                break;
            }
            if ($_REQUEST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_REQUEST['search']['value']);
                } else {
                    $this->db->or_like($item, $_REQUEST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            ++$i;
        }

        if (isset($_REQUEST['order'])) {
            $this->db->order_by($this->column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if (isset($_REQUEST['length'])) {
            if ($_REQUEST['length'] != -1) {
                $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
            }
        }
        if ($this->whereData != '') {
            $this->db->where($this->whereData);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        if ($this->whereData != '') {
            $this->db->where($this->whereData);
        }
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        if ($this->whereData != '') {
            $this->db->where($this->whereData);
        }

        return $this->db->count_all_results();
    }
}
