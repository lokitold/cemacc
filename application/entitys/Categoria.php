<?php

class Application_Entity_Categoria extends Core_Entity {

    protected $_id;
    protected $_nombre;
    protected $_tipo;
    protected $_flagActivo;

    public function identify($id) {
        $service = $this->setService('Categoria');
        $data = $service->getCategoria($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['categoria_id'];
        $this->_nombre = $data['categoria_nombre'];
        $this->_tipo = $data['categoria_tipo'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'categoria_id' => $this->_id,
            'categoria_nombre' => $this->_nombre,
            'categoria_tipo' => $this->_tipo,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = self::setService('Categoria');
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }

    public function update() {
        $service = self::setService('Categoria');
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = self::setService('Categoria');
        return $service->delete($id);
    }

    static function getAllCategoria() {
        $service = new Application_Model_Categoria();
        return $service->getCategoria();
    }
    
    static function getAllCategoriaVentas() {
        $service = new Application_Model_Categoria();
        return $service->getCategoriaVentas();
    }
    
    static function getAllCategoriaByTipo($tipo) {
        $service = new Application_Model_Categoria();
        return $service->getCategoriaByTipo($tipo);
    }
    
    static function activar($id,$estado){
        $service = self::setService('Juzgado');
        $data = array(
            'juzgado_flag_activo' => $estado,
        );
        return $service->update($id,$data);
    }

}