<?php

class Application_Model_AdquisicionDetalle extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idAdquisicionDetalle
     * @return array $data       
     */
    public function getAdquisicionDetalle($idAdquisicionDetalle = '') {
        $tableAdquisicionDetalle = new Application_Model_DbTable_AdquisicionDetalle();
        $smt = $tableAdquisicionDetalle->select();
        if ($idAdquisicionDetalle != '')
            $smt = $smt->where('adquisicion_detalle_id =?', $idAdquisicionDetalle);
        $smt = $smt->query();
        if ($idAdquisicionDetalle == '')
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
        $tableAdquisicionDetalle = new Application_Model_DbTable_AdquisicionDetalle();
        try {
            $tableAdquisicionDetalle->insert($data);
            $result = $tableAdquisicionDetalle->getAdapter()->lastInsertId();
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
        $tableAdquisicionDetalle = new Application_Model_DbTable_AdquisicionDetalle();
        try {
            $where = $tableAdquisicionDetalle->getAdapter()->quoteInto('adquisicion_detalle_id =?', $id);
            $result = $tableAdquisicionDetalle->update($data, $where);
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
        $tableAdquisicionDetalle = new Application_Model_DbTable_AdquisicionDetalle();
        try {
            $where = $tableAdquisicionDetalle->getAdapter()->quoteInto('adquisicion_detalle_id =?', $id);
            $result = $tableAdquisicionDetalle->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }
    
   
}