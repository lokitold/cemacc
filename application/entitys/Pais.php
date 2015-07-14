<?php

class Application_Entity_Pais extends Core_Entity {
    
    const PAIS_PERU = 173;
    
    protected $_id;
    protected $_nombre;
    
    public function identify($id) {
        $service = $this->setService('Pais');
        $data = $service->getPais($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['pais_id'];
        $this->_nombre = $data['pais_nombre'];
    }
    
     private function setDataBaseProperties() {
        $data = array(
            'pais_id' => $this->_id,
            'pais_nombre' => $this->_nombre,
        );
        return $this->cleanArray($data);
    }
    
    static function getAllPais(){
        $service = new Application_Model_Pais();
        return $service->getPais();
    }
}