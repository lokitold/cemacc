<?php

class Application_Entity_Plantilla extends Core_Entity {
    
    protected $_id;
    protected $_nombre;
    protected $_contenido;
    protected $_replace;
    
    const REGISTRO_USUARIO = 1;
    const RECUPERAR_CONTRASENA = 2;
    
    public function identify($id) {
        $service = $this->setService('Plantilla');
        $data = $service->getPlantilla($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['plantilla_id'];
        $this->_nombre = $data['plantilla_nombre'];
        $this->_contenido = $data['plantilla_contenido'];
        $this->_replace = $data['plantilla_label_replace'];
    }
}