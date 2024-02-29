<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert(string $table, $data)
    {
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function update(string $table, $where, $data)
    {
        return $this->db->update($table, $data, $where);
    }

    public function delete(string $table, $where)
    {
        return $this->db->delete($table, $where);
    }

    public function get_all(string $table)
    {
        $query = $this->db->get($table);
        return $query;
    }

    public function find(string $table, $where)
    {
        $query = $this->db->where($where);
        $query = $this->db->from($table);
        $query = $this->db->get();
        return $query;
    }

    public function count_where($table, $column, $id)
    {
        $query = $this->db->query("SELECT COUNT(*) as count FROM $table where $column = $id");
        return $query->row()->count;
    }
    public function count_wheree($table, $column, $id, $and, $ids)
    {
        $query = $this->db->query("SELECT COUNT(*) as count FROM $table where $column = $id and $and = $ids and is_deleted=0");
        return $query->row()->count;
    }

    public function get(array $data)
    {
        //decleare select
        if (isset($data['select'])) {
            $this->db->select($data['select']);
        }
        //decleare from
        if (isset($data['from'])) {
            $this->db->from($data['from']);
        }
        //deceleare join
        if (isset($data['join'])) {
            foreach ($data['join'] as $item_join) {
                $explode_item_join = explode(',', $item_join);
                //param 1
                isset($explode_item_join[0]) ? $param_1 = $explode_item_join[0] : $param_1 = '';
                //param 2
                isset($explode_item_join[1]) ? $param_2 = $explode_item_join[1] : $param_2 = '';
                //param 3
                isset($explode_item_join[2]) ? $param_3 = $explode_item_join[2] : $param_3 = '';

                $this->db->join($param_1, $param_2, $param_3);
            }
        }
        if (isset($data['join_custom'])) {
            foreach ($data['join_custom'] as $table_name => $item_join) {
                $explode_item_join = explode(',', $item_join);
                $last_param = end($explode_item_join);
                $value_param = str_replace(',' . $last_param, ' ', $item_join);
                $this->db->join($table_name, $value_param, $last_param);
            }
        }
        //decleare where 
        if (isset($data['where'])) {
            $this->db->where($data['where']);
        }
        //define between
        if (isset($data['between'])) {
            foreach ($data['between'] as $field_name => $between_values) {
                if (count($between_values) === 2) {
                    // Make sure there are exactly two values provided
                    $this->db->where("$field_name BETWEEN '{$between_values[0]}' AND '{$between_values[1]}'", '', false);
                }
            }
        }
        if (isset($data['or_where'])) {
            $this->db->or_where($data['or_where']);
        }

        //define where in
        if (isset($data['where_in'])) {
            foreach ($data['where_in'] as $field_name => $array_list) {
                $this->db->where_in($field_name, $array_list);
            }
        }
        //define where not in
        if (isset($data['where_not_in'])) {
            foreach ($data['where_not_in'] as $field_name => $array_list) {
                $this->db->where_not_in($field_name, $array_list);
            }
        }
        //define not like
        if (isset($data['not_like'])) {
            foreach ($data['not_like'] as $field_name => $item_not_like) {
                $explode_item_not_like = explode(',', $item_not_like);
                if (count($explode_item_not_like) > 1) {
                    $param2 = end($explode_item_not_like);
                    $param1 = substr($item_not_like, 0, strlen($item_not_like) - (strlen($param2) + 1));
                    //add to query
                    $this->db->not_like($field_name, $param1, $param2);
                } else {
                    $this->db->not_like($field_name, $item_not_like);
                }
            }
        }
        //define like
        if (isset($data['like'])) {
            foreach ($data['like'] as $field_name => $item_like) {
                $explode_item_like = explode(',', $item_like);
                if (count($explode_item_like) > 1) {
                    $param2 = end($explode_item_like);
                    $param1 = substr($item_like, 0, strlen($item_like) - (strlen($param2) + 1));
                    //add to query
                    $this->db->like($field_name, $param1, $param2);
                } else {
                    $this->db->not_like($field_name, $item_like);
                }
            }
        }
        //decleare order by 
        if (isset($data['order_by'])) {
            $explode_order_by = explode(',', $data['order_by']);
            if (count($explode_order_by) > 1) {
                $param2 = end($explode_order_by);
                $param1 = substr($data['order_by'], 0, strlen($data['order_by']) - (strlen($param2) + 1));
                $this->db->order_by($param1, $param2);
            } else {
                $this->db->order_by($data['order_by']);
            }
        }
        //decleare group by
        if (isset($data['group_by'])) {
            $this->db->group_by($data['group_by']);
        }
        //decleare having
        if (isset($data['having'])) {
            $this->db->having($data['having']);
        }
        //decleare limit 
        if (isset($data['limit'])) {
            if (is_array($data['limit'])) {
                //when array data
                //decide use 
                if (isset($data['limit']['limit']) && isset($data['limit']['start'])) {
                    //use both
                    $this->db->limit($data['limit']['limit'], $data['limit']['start']);
                } else {
                    if (isset($data['limit']['limit'])) {
                        $this->db->limit($data['limit']['limit']);
                    }
                }
            } else {
                //when not array
                $this->db->limit($data['limit']);
            }
        }
        //final deleare using get
        $query = $this->db->get();
        return $query;
    }

    public function custom(string $query)
    {
        $query = $this->db->query($query);
        return $query;
    }
}
