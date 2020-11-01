<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
    /*public function get_list($offset = 0, $numOfRows = 9999, $filters = array(), $sort = array())
    {
        $sortString = 'ORDER BY `student`.fullname ASC';
        if (isset($sort['field'])) {
            $sortString = 'ORDER BY '.$sort['field'].' '.$sort['direction'];
        }

        $filterString = '';
        if ($filters == NULL) {
            $filters = array();
        }
        foreach ($filters as $key => $val) {
            switch ($key) {
                default: {
                    //studentCode, branchId
                    if ($filterString != "") {
                        $filterString .= " AND";
                    }
                    if (is_string($val)) {
                        $filterString .= " {$key}='{$val}'";
                    } else {
                        $val = intval($val);
                        $filterString .= " {$key}={$val}";
                    }
                    break;
                }
            }
        }
        if ($filterString == '') {
            $filterString = '1';
        }

        $query = $this->db->query("
            SELECT `student`.*
            FROM `student` 
            WHERE {$filterString}
            {$sortString}
            LIMIT ?, ?
        ", array($offset, $numOfRows));
        $entries = $query->result_array();

        $query = $this->db->query("SELECT COUNT(id) AS 'totalRows' FROM student WHERE 1");
        $totalRows = $query->row_array()['totalRows'];
        return array(
            'result' => $entries,
            'count' => $totalRows
        );
    }*/
    public function get($id = null, $studentCode = null, $branchId = null)
    {
        /**
         * If a student should be get by table UID, just supplying the $id is enough
         * If student should be get by studentCode, then the branch MUST be provided
        */
        /*$query = $this->db->query("SELECT * FROM `student` WHERE `id`=?", $id);
        return $query->row_array();*/
    }
    public function update($thisStudent)
    {
        //TODO: Make a more flexible version where all fields are updated, DEPENDING on the fields available
        $this->db->query("UPDATE `user` SET `fullname`=? WHERE `id`=?", array($thisStudent['fullName'], $thisStudent['id']));
    }
    public function insert($thisStudent)
    {
    }
}
?>