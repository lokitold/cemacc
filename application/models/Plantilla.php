<?php

class Application_Model_Plantilla extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idPlantilla    
     * @return array        
     */
    public function getPlantilla($idPlantilla = '') {
        $tablePlantilla = new Application_Model_DbTable_Plantilla();
        $smt = $tablePlantilla->select();
        if ($idPlantilla != '')
            $smt = $smt->where('plantilla_id =?', $idPlantilla);
        $smt = $smt->query();
        if ($idPlantilla == '')
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
        $tablePlantilla = new Application_Model_DbTable_Plantilla();
        try {
            $tablePlantilla->insert($data);
            $result = $tablePlantilla->getAdapter()->lastInsertId();
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
        $tablePlantilla = new Application_Model_DbTable_Plantilla();
        try {
            $where = $tablePlantilla->getAdapter()->quoteInto('plantilla_id =?', $id);
            $result = $tablePlantilla->update($data, $where);
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
        $tablePlantilla = new Application_Model_DbTable_Plantilla();
        try {
            $where = $tablePlantilla->getAdapter()->quoteInto('plantilla_id =?', $id);
            $result = $tablePlantilla->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }
   
}