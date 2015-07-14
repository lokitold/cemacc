<?php

class Application_Model_Permission extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param int $idPermission
     * @param string $flagActivo
     * @return array        
     */
    public function getPermission($idPermission = '', $flagActivo = '') {
        $tablePermission = new Application_Model_DbTable_Permission();
        $smt = $tablePermission->select();
        if ($idPermission != '')
            $smt = $smt->where('proveedor_id =?', $idPermission);
        if ($flagActivo != '')
            $smt = $smt->where('proveedor_flag_activo =?', $flagActivo);
        $smt = $smt->query();
        if ($idPermission == '')
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
        $tablePermission = new Application_Model_DbTable_Permission();
        try {
            $tablePermission->insert($data);
            $result = $tablePermission->getAdapter()->lastInsertId();
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
        $tablePermission = new Application_Model_DbTable_Permission();
        try {
            $where = $tablePermission->getAdapter()->quoteInto('permission_id =?', $id);
            $result = $tablePermission->update($data, $where);
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
        $tablePermission = new Application_Model_DbTable_Permission();
        try {
            $where = $tablePermission->getAdapter()->quoteInto('permission_id =?', $id);
            $result = $tablePermission->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

   
}

