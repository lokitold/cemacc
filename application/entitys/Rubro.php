<?php

class Application_Entity_Rubro extends Core_Entity {

    protected $_id;
    protected $_nombre;
    protected $_flagActivo;

    public function identify($id) {
        $service = $this->setService('Rubro');
        $data = $service->getRubro($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['rubro_id'];
        $this->_nombre = $data['rubro_nombre'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'rubro_id' => $this->_id,
            'rubro_nombre' => $this->_nombre,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = self::setService('Rubro');
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }

    public function update() {
        $service = self::setService('Rubro');
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = self::setService('Rubro');
        return $service->delete($id);
    }

    static function getAllRubro() {
        $service = new Application_Model_Rubro();
        return $service->getRubro();
    }
    
    static function activar($id,$estado){
        $service = self::setService('Juzgado');
        $data = array(
            'juzgado_flag_activo' => $estado,
        );
        return $service->update($id,$data);
    }
    
    static function getSubcategoriaByCategoria($id){
        $service = new Application_Model_Subcategoria();
        return $service->getSubcategoriaByCategoria($id);
    }


}