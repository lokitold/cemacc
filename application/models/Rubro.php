<?php

class Application_Model_Rubro extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idRubro    
     * @return array $data       
     */
    public function getRubro($idRubro = '') {
        $tableRubro = new Application_Model_DbTable_Rubro();
        $smt = $tableRubro->select();
        if ($idRubro != '')
            $smt = $smt->where('rubro_id =?', $idRubro);
        $smt = $smt->query();
        if ($idRubro == '')
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
        $tableRubro = new Application_Model_DbTable_Rubro();
        try {
            $tableRubro->insert($data);
            $result = $tableRubro->getAdapter()->lastInsertId();
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
        $tableRubro = new Application_Model_DbTable_Rubro();
        try {
            $where = $tableRubro->getAdapter()->quoteInto('rubro_id =?', $id);
            $result = $tableRubro->update($data, $where);
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
        $tableRubro = new Application_Model_DbTable_Rubro();
        try {
            $where = $tableRubro->getAdapter()->quoteInto('rubro_id =?', $id);
            $result = $tableRubro->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }
    
    /**
     * @param int $idCategoria
     * @return array $data
     */
    public function getSubcategoriaByCategoria($idCategoria) {
        $tableRubro = new Application_Model_DbTable_Subcategoria();
        $smt = $tableRubro->select()
            ->where('categoria_id =?', $idCategoria);
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }
   
}