<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classification extends CI_Model {
    public function get_list($offset = 0, $numOfRows = 9999, $filters = array(), $sort = array())
    {
        $sortString = 'ORDER BY `classification`.id ASC';
        if (isset($sort['field'])) {
            $sortString = 'ORDER BY '.$sort['field'].' '.$sort['direction'];
        }

        $filterString = '';
        if ($filters == NULL) {
            $filters = array();
        }
        foreach ($filters as $key => $val) {
            /*switch ($key) {
                case 'scheduleGroupId': {
                    $val = intval($val);
                    $filterString .= " `employee`.scheduleGroupId={$val}";
                    break;
                }
            }*/
            switch ($key) {
                case 'userId': {
                    $val = intval($val);
                    $filterString .= " `classification`.userId={$val}";
                    break;
                }
            }
        }
        if ($filterString == '') {
            $filterString = '1';
        }

        $query = $this->db->query("
            SELECT *
            FROM `classification` 
            WHERE {$filterString}
            {$sortString}
            LIMIT ?, ?
        ", array($offset, $numOfRows));
        $entries = $query->result_array();

        $query = $this->db->query("SELECT COUNT(id) AS 'totalRows' FROM classification WHERE {$filterString}");
        $totalRows = $query->row_array()['totalRows'];
        return array(
            'result' => $entries,
            'count' => $totalRows
        );
    }
    public function get($id)
    {
        $query = $this->db->query("SELECT * FROM `classification` WHERE `id`=?", $id);
        return $query->row_array();
    }
    public function update($userId, $thisItem)
    {
        $query = $this->db->query("UPDATE `classification` SET  
            `outletName`=?,`outletSize`=?,`monthlyTurnover`=?,`customersPerDay`=?,`skuCount`=?,`bayCount`=?,
            `parkingCount`=?,`counterCount`=?,`staffCount`=?,`airCon`=?,`coolerDoor`=?,`iceCreamFreezer`=?,
            `meatFreezer`=?,`foodFreezer`=?,`trolley`=?,`creditCard`=?
            WHERE `id`=? AND `userId`=?", array(
                $thisItem['outletName'],
                $thisItem['outletSize'],
                $thisItem['monthlyTurnover'],
                $thisItem['customersPerDay'],
                $thisItem['skuCount'],
                $thisItem['bayCount'],
                $thisItem['parkingCount'],
                $thisItem['counterCount'],
                $thisItem['staffCount'],
                $thisItem['airCon'],
                $thisItem['coolerDoor'],
                $thisItem['iceCreamFreezer'],
                $thisItem['meatFreezer'],
                $thisItem['foodFreezer'],
                $thisItem['trolley'],
                $thisItem['creditCard'],
                $thisItem['id'],
                $userId
            )
        );
    
        if (isset($thisItem['image']) && $thisItem['image'] !== "") {
            //image specified
            $this->db->query("UPDATE `classification` SET `image`=? WHERE `id`=? AND `userId`=?;", array($thisItem['image'], $thisItem['id'], $userId));
        }
    }
    public function add($userId, $thisItem)
    {

        $this->db->query("INSERT INTO `classification` 
            (`userId`, `outletName`,`outletSize`,`monthlyTurnover`,`customersPerDay`,`skuCount`,`bayCount`,
            `parkingCount`,`counterCount`,`staffCount`,`airCon`,`coolerDoor`,`iceCreamFreezer`,
            `meatFreezer`,`foodFreezer`,`trolley`,`creditCard`) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);", array(
                $userId,
                $thisItem['outletName'],
                $thisItem['outletSize'],
                $thisItem['monthlyTurnover'],
                $thisItem['customersPerDay'],
                $thisItem['skuCount'],
                $thisItem['bayCount'],
                $thisItem['parkingCount'],
                $thisItem['counterCount'],
                $thisItem['staffCount'],
                $thisItem['airCon'],
                $thisItem['coolerDoor'],
                $thisItem['iceCreamFreezer'],
                $thisItem['meatFreezer'],
                $thisItem['foodFreezer'],
                $thisItem['trolley'],
                $thisItem['creditCard']
        ));
        $newId = $this->db->insert_id();

        if (isset($thisItem['image']) && $thisItem['image'] !== "") {
            //image specified
            $this->db->query("UPDATE `classification` SET `image`=? WHERE `id`=?;", array($thisItem['image'], $newId));
        }

        return $newId;
    }
    /*public function delete($id)
    {
        $this->db->query("DELETE FROM `supplier` WHERE `id`=?;", array($id));
    }*/
}
?>