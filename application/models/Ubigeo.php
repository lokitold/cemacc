<?php

class Application_Model_Ubigeo extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idUbigeo    
     * @return array        
     */
    public function getUbigeo($idUbigeo = '') {
        $tableUbigeo = new Application_Model_DbTable_Ubigeo();
        $smt = $tableUbigeo->select();
        if ($idUbigeo != '')
            $smt = $smt->where('ubigeo_id =?', $idUbigeo);
        $smt = $smt->query();
        if ($idUbigeo == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }
    
     /**
     * @param string $departamento   
     * @return array        
     */
    public function getDepartamento($departamento = '') {
        $tableUbigeo = new Application_Model_DbTable_Ubigeo();
        $smt = $tableUbigeo->select();
        if ($departamento != '')
            $smt = $smt->where('departamento = ?', $departamento);
        
        $smt = $smt->group('departamento');
        $smt = $smt->query();
        if ($departamento == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }
    
    /**
     * @param string $departamento
     * @return array $data
     */
    public function getProvinciaByDepartamento($departamento) {
        $tableUbigeo = new Application_Model_DbTable_Ubigeo();
        $smt = $tableUbigeo->select()
            ->where('departamento = ?', $departamento)
            ->group('provincia');
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }
    
    /**
     * @param string $provincia
     * @return array $data
     */
    public function getDistritoByProvincia($provincia) {
        $tableUbigeo = new Application_Model_DbTable_Ubigeo();
        $smt = $tableUbigeo->select()
            ->where('provincia = ?', $provincia);
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }
    
    /**
     * @param string $provincia
     * @return array $data
     */
    public function getUbigeoByCampos($departamento,$provincia,$distrito) {
        $tableUbigeo = new Application_Model_DbTable_Ubigeo();
        $smt = $tableUbigeo->select()
            ->where('departamento = ?', $departamento)
            ->where('provincia = ?', $provincia)
            ->where('distrito = ?', $distrito);
        $smt = $smt->query();
        $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }

    

}
