<?php

class Application_Entity_Ubigeo extends Core_Entity {
    
    protected $_id;
    protected $_departamento;
    protected $_provincia;
    protected $_distrito;
   
    public function identify($id) {
        $service = $this->setService('Ubigeo');
        $data = $service->getUbigeo($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['ubigeo_id'];
        $this->_departamento = $data['departamento'];
        $this->_provincia = $data['provincia'];
        $this->_distrito = $data['distrito'];
    }
    
     private function setDataBaseProperties() {
        $data = array(
            'ubigeo_id' => $this->_id,
            'departamento' => $this->_departamento,
            'provincia' => $this->_provincia,
            'distrito' => $this->_distrito,
        );
        return $this->cleanArray($data);
    }
    
    static function getAllDepartamento(){
        $service = new Application_Model_Ubigeo();
        return $service->getDepartamento();
    }
    
    static function getProvinciaByDepartamento($departamento){
        $service = new Application_Model_Ubigeo();
        return $service->getProvinciaByDepartamento($departamento);
    }
    
    static function getDistritoByProvincia($provincia){
        $service = new Application_Model_Ubigeo();
        return $service->getDistritoByProvincia($provincia);
    }
    
    static function getUbigeoByCampos($departamento,$provincia,$distrito){
        $service = new Application_Model_Ubigeo();
        return $service->getUbigeoByCampos($departamento,$provincia,$distrito);
    }
}