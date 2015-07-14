<?php

class Application_Entity_Permission extends Core_Entity {

    protected $_id;
    
    public function identify($id) {
        $service = $this->setService('Permission');
        $data = $service->getProveedor($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }
    
    
}