<?php

class Application_Entity_Subcategoria extends Core_Entity {

    protected $_id;
    protected $_nombre;
    protected $_categoriaId;
    protected $_flagActivo;

    public function identify($id) {
        $service = $this->setService('Subcategoria');
        $data = $service->getSubcategoria($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['subcategoria_id'];
        $this->_nombre = $data['subcategoria_nombre'];
        $this->_categoriaId = $data['categoria_id'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'subcategoria_id' => $this->_id,
            'subcategoria_nombre' => $this->_nombre,
            'categoria_id' => $this->_categoriaId,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = self::setService('Subcategoria');
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }

    public function update() {
        $service = self::setService('Subcategoria');
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = self::setService('Subcategoria');
        return $service->delete($id);
    }

    static function getAllSubcategoria() {
        $service = new Application_Model_SubCategoria();
        return $service->getSubcategoria();
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