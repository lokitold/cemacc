<?php

class Application_Model_Pais extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idPais    
     * @return array        
     */
    public function getPais($idPais = '') {
        $tablePais = new Application_Model_DbTable_Pais();
        $smt = $tablePais->select();
        if ($idPais != '')
            $smt = $smt->where('pais_id =?', $idPais);
        $smt = $smt->query();
        if ($idPais == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }

    

}
