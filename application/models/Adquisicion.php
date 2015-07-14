<?php

class Application_Model_Adquisicion extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idAdquisicion
     * @return array $data       
     */
    public function getAdquisicion($idAdquisicion = '') {
        $tableAdquisicion = new Application_Model_DbTable_Adquisicion();
        $smt = $tableAdquisicion->select();
        if ($idAdquisicion != '')
            $smt = $smt->where('adquisicion_id =?', $idAdquisicion);
        $smt = $smt->query();
        if ($idAdquisicion == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }
    
    /**
     * @param string $idEmpresa
     * @return array $data       
     */
    public function getAdquisicionByEmpresa($idEmpresa) {
        $tableAdquisicion = new Application_Model_DbTable_Adquisicion();
        $smt = $tableAdquisicion->select()
            ->where('empresa_id =?', $idEmpresa);
        $smt = $smt->query();
        $result = $smt->fetchAll();
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
        $tableAdquisicion = new Application_Model_DbTable_Adquisicion();
        try {
            $tableAdquisicion->insert($data);
            $result = $tableAdquisicion->getAdapter()->lastInsertId();
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
        $tableAdquisicion = new Application_Model_DbTable_Adquisicion();
        try {
            $where = $tableAdquisicion->getAdapter()->quoteInto('adquisicion_id =?', $id);
            $result = $tableAdquisicion->update($data, $where);
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
        $tableAdquisicion = new Application_Model_DbTable_Adquisicion();
        try {
            $where = $tableAdquisicion->getAdapter()->quoteInto('adquisicion_id =?', $id);
            $result = $tableAdquisicion->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }
    
   
}