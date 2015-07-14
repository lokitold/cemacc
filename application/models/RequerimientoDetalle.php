<?php

class Application_Model_RequerimientoDetalle extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idRequerimientoDetalle
     * @return array $data       
     */
    public function getRequerimientoDetalle($idRequerimientoDetalle = '') {
        $tableRequerimientoDetalle = new Application_Model_DbTable_RequerimientoDetalle();
        $smt = $tableRequerimientoDetalle->select();
        if ($idRequerimientoDetalle != '')
            $smt = $smt->where('requerimiento_detalle_id =?', $idRequerimientoDetalle);
        $smt = $smt->query();
        if ($idRequerimientoDetalle == '')
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
        $tableRequerimientoDetalle = new Application_Model_DbTable_RequerimientoDetalle();
        try {
            $tableRequerimientoDetalle->insert($data);
            $result = $tableRequerimientoDetalle->getAdapter()->lastInsertId();
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
        $tableRequerimientoDetalle = new Application_Model_DbTable_RequerimientoDetalle();
        try {
            $where = $tableRequerimientoDetalle->getAdapter()->quoteInto('requerimiento_detalle_id =?', $id);
            $result = $tableRequerimientoDetalle->update($data, $where);
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
        $tableRequerimientoDetalle = new Application_Model_DbTable_RequerimientoDetalle();
        try {
            $where = $tableRequerimientoDetalle->getAdapter()->quoteInto('requerimiento_detalle_id =?', $id);
            $result = $tableRequerimientoDetalle->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }
    
   
}