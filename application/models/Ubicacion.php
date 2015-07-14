<?php

class Application_Model_Ubicacion extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idUbicacion  
     * @return array        
     */
    public function getUbicacion($idUbicacion = '') {
        $tableUbicacion = new Application_Model_DbTable_Ubicacion();
        $smt = $tableUbicacion->select();
        if ($idUbicacion != '')
            $smt = $smt->where('ubicacion_id =?', $idUbicacion);
        $smt = $smt->query();
        if ($idUbicacion == '')
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
        $tableUbicacion = new Application_Model_DbTable_Ubicacion();
        try {
            $tableUbicacion->insert($data);
            $result = $tableUbicacion->getAdapter()->lastInsertId();
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
        $tableUbicacion = new Application_Model_DbTable_Ubicacion();
        try {
            $where = $tableUbicacion->getAdapter()->quoteInto('ubicacion_id =?', $id);
            $result = $tableUbicacion->update($data, $where);
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
        $tableUbicacion = new Application_Model_DbTable_Ubicacion();
        try {
            $where = $tableUbicacion->getAdapter()->quoteInto('ubicacion_id =?', $id);
            $result = $tableUbicacion->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }


}
