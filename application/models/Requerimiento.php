<?php

class Application_Model_Requerimiento extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idRequerimiento
     * @return array $data       
     */
    public function getRequerimiento($idRequerimiento = '') {
        $tableRequerimiento = new Application_Model_DbTable_Requerimiento();
        $smt = $tableRequerimiento->select();
        if ($idRequerimiento != '')
            $smt = $smt->where('requerimiento_id =?', $idRequerimiento);
        $smt = $smt->query();
        if ($idRequerimiento == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @param array $data
     * @return int|boolean
     */
    public function insert($data) {
        if (!is_array($data)) {
            return false;
        }
        $tableRequerimiento = new Application_Model_DbTable_Requerimiento();
        try {
            $tableRequerimiento->insert($data);
            $result = $tableRequerimiento->getAdapter()->lastInsertId();
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    /**
     * @param int $id
     * @param array $data
     * @return int|boolean
     */
    public function update($id, $data) {
        if (!is_array($data)) {
            return false;
        }
        $tableRequerimiento = new Application_Model_DbTable_Requerimiento();
        try {
            $where = $tableRequerimiento->getAdapter()->quoteInto('requerimiento_id =?', $id);
            $result = $tableRequerimiento->update($data, $where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    /**
     * @param int $id
     * @return int|boolean
     */
    public function delete($id) {
        $tableRequerimiento = new Application_Model_DbTable_Requerimiento();
        try {
            $where = $tableRequerimiento->getAdapter()->quoteInto('requerimiento_id =?', $id);
            $result = $tableRequerimiento->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }
    
   
}