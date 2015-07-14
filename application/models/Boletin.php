<?php

class Application_Model_Boletin extends Core_Model {

    public function __construct() {
        
    }

    public function getBoletin($idBoletin = '') {
        $tableBoletin = new Application_Model_DbTable_Boletin();
        $smt = $tableBoletin->select();
        if ($idBoletin != '')
            $smt = $smt->where('boletin_id =?', $idBoletin);
        $smt = $smt->query();
        if ($idBoletin == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }

    public function insert($data) {
        if (!is_array($data)) {
            return false;
        }
        $tableBoletin = new Application_Model_DbTable_Boletin();
        try {
            $tableBoletin->insert($data);
            $result = $tableBoletin->getAdapter()->lastInsertId();
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    public function update($id, $data) {
        if (!is_array($data)) {
            return false;
        }
        $tableBoletin = new Application_Model_DbTable_Boletin();
        try {
            $where = $tableBoletin->getAdapter()->quoteInto('boletin_id =?', $id);
            $result = $tableBoletin->update($data, $where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    public function delete($id) {
        $tableBoletin = new Application_Model_DbTable_Boletin();
        try {
            $where = $tableBoletin->getAdapter()->quoteInto('boletin_id =?', $id);
            $result = $tableBoletin->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

}
