<?php

class Application_Model_Subcategoria extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idSubcategoria    
     * @return array $data       
     */
    public function getSubcategoria($idSubcategoria = '') {
        $tableSubcategoria = new Application_Model_DbTable_Subcategoria();
        $smt = $tableSubcategoria->select();
        if ($idSubcategoria != '')
            $smt = $smt->where('subcategoria_id =?', $idSubcategoria);
        $smt = $smt->query();
        if ($idSubcategoria == '')
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
        $tableSubcategoria = new Application_Model_DbTable_Subcategoria();
        try {
            $tableSubcategoria->insert($data);
            $result = $tableSubcategoria->getAdapter()->lastInsertId();
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
        $tableSubcategoria = new Application_Model_DbTable_Subcategoria();
        try {
            $where = $tableSubcategoria->getAdapter()->quoteInto('subcategoria_id =?', $id);
            $result = $tableSubcategoria->update($data, $where);
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
        $tableSubcategoria = new Application_Model_DbTable_Subcategoria();
        try {
            $where = $tableSubcategoria->getAdapter()->quoteInto('subcategoria_id =?', $id);
            $result = $tableSubcategoria->delete($where);
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
        $tableSubcategoria = new Application_Model_DbTable_Subcategoria();
        $smt = $tableSubcategoria->select()
            ->where('categoria_id =?', $idCategoria);
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }
   
}