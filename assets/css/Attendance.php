<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Model {
    public function get_list($offset = 0, $numOfRows = 5)
    {
        $query = $this->db->query("
            SELECT attendance.id as id,checkIn, checkOut, employeeId, date, humanName, scheduleGroupId, schedule_group.groupName AS 'group' 
                FROM attendance
            INNER JOIN employee 
                ON attendance.employeeId=employee.id
            INNER JOIN schedule_group
                ON schedule_group.id=employee.scheduleGroupId
            WHERE 1
            ORDER BY `attendance`.`id` ASC
            LIMIT ?, ?
        ", array($offset, $numOfRows));
        $entries = $query->result_array();

        $query = $this->db->query("
            SELECT COUNT(attendance.id) AS totalRows 
                FROM attendance
            WHERE 1
            ORDER BY `attendance`.`id` ASC
        ");
        $totalRows = intval($query->row_array()['totalRows']);
        $response = array(
            'result' => $entries,
            'count' => $totalRows
        );

        return $response;
    }
    public function get($id)
    {
        $query = $this->db->query("SELECT * FROM `schedule_group` WHERE `id`=?", array($id));
        return $query->row_array();
    }
}
?>