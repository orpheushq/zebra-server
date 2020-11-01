<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Model {
    public function get_list($offset = 0, $numOfRows = 9999, $filters = array(), $sort = array())
    {
        $sortString = 'ORDER BY `attendance`.id ASC';
        if (isset($sort['field'])) {
            $sortString = 'ORDER BY '.$sort['field'].' '.$sort['direction'];
        }

        $filterString = '';
        if ($filters == NULL) {
            $filters = array();
        }
        foreach ($filters as $key => $val) {
            switch ($key) {
                case 'studentId': {
                    $filterString .= " `attendance`.studentId = {$val}";
                    break;
                }
                case 'date': {
                    if ($filterString !== "") $filterString .= " AND ";
                    $filterString .= " `attendance`.date = '{$val}'";
                    break;
                }
            }
        }
        if ($filterString == '') {
            $filterString = '1';
        }

        $query = $this->db->query("
            SELECT `attendance`.*,`student`.fullname AS 'fullname',`student`.swinId AS 'swinId'
            FROM `attendance` 
            INNER JOIN `student` ON `student`.id = `attendance`.studentId
            WHERE {$filterString}
            {$sortString}
            LIMIT ?, ?
        ", array($offset, $numOfRows));
        $entries = $query->result_array();

        $query = $this->db->query("SELECT COUNT(id) AS 'totalRows' FROM attendance WHERE 1");
        $totalRows = $query->row_array()['totalRows'];
        return array(
            'result' => $entries,
            'count' => $totalRows
        );
    }
    public function get($id)
    {
        $query = $this->db->query("SELECT * FROM `supplier` WHERE `id`=?", $id);
        return $query->row_array();
    }
    /*public function update($thisSupplier)
    {
        if (is_string($thisSupplier['tags'])) {
            //tags is a string, make it an object to be used with clean_tags()
            $thisSupplier['tags'] = json_decode($thisSupplier['tags'], true);
        }
        //clean tags and standardize values
        $this->clean_tags($thisSupplier['tags']);

        if (!is_string($thisSupplier['tags'])) {
            //tags is not given as a string. convert to a string
            $thisSupplier['tags'] = json_encode($thisSupplier['tags'], true);
        }
        //var_dump($thisSupplier['tags']);
        //exit;
        $query = $this->db->query("UPDATE `supplier` SET  
            `company`=?, 
            `contactName`=?, 
            `address`=?, 
            `tags`=?, 
            `phoneNumber`=?, 
            `email`=? 
            WHERE `id`=?", array(
                $thisSupplier['company'],
                $thisSupplier['contactName'],
                $thisSupplier['address'],
                $thisSupplier['tags'],
                $thisSupplier['phoneNumber'],
                $thisSupplier['email'],
                $thisSupplier['id']
            )
        );
    }*/
    public function add($thisAttendance)
    {
        $this->db->query("INSERT INTO `attendance` (`studentId`,`date`,`time`) VALUES (?,?,?);", array(
            $thisAttendance["studentId"],
            $thisAttendance["date"],
            $thisAttendance["time"],
        ));
        return $this->db->insert_id();
    }
    public function delete($id)
    {
        $this->db->query("DELETE FROM `supplier` WHERE `id`=?;", array($id));
    }
}
?>