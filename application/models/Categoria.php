<?php

class Application_Model_Categoria extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idCategoria
     * @return array $data       
     */
    public function getCategoria($idCategoria = '') {
        $tableCategoria = new Application_Model_DbTable_Categoria();
        $smt = $tableCategoria->select();
        if ($idCategoria != '')
            $smt = $smt->where('categoria_id =?', $idCategoria);
        $smt = $smt->query();
        if ($idCategoria == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }
    
    /**
     * @return array $data       
     */
    public function getCategoriaVentas() {
        $tableCategoria = new Application_Model_DbTable_Categoria();
        $smt = $tableCategoria->select()
            ->where('categoria_tipo in(1,2)');
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }
    
    /**
     * @param string $tipoCategoria
     * @return array $data       
     */
    public function getCategoriaByTipo($tipoCategoria) {
        $tableCategoria = new Application_Model_DbTable_Categoria();
        $smt = $tableCategoria->select()
            ->where('categoria_tipo =?',$tipoCategoria);
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
        $tableCategoria = new Application_Model_DbTable_Categoria();
        try {
            $tableCategoria->insert($data);
            $result = $tableCategoria->getAdapter()->lastInsertId();
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
        $tableCategoria = new Application_Model_DbTable_Categoria();
        try {
            $where = $tableCategoria->getAdapter()->quoteInto('categoria_id =?', $id);
            $result = $tableCategoria->update($data, $where);
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
        $tableCategoria = new Application_Model_DbTable_Categoria();
        try {
            $where = $tableCategoria->getAdapter()->quoteInto('cateogria_id =?', $id);
            $result = $tableCategoria->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }
    
   
}