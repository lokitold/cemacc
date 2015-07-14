<?php

class Application_Entity_AdquisicionDetalle extends Core_Entity {

    protected $_id;
    protected $_adquisicionId;
    protected $_nombre;
    protected $_descripcion;
    protected $_cantidad;
    protected $_precio;
    protected $_flagActivo;

    public function identify($id) {
        $service = new Application_Model_AdquisicionDetalle;
        $data = $service->getAdquisicionDetalle($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['adquisicion_detalle_id'];
        $this->_adquisicionId = $data['adquisicion_id'];
        $this->_nombre = $data['adquisicion_detalle_nombre'];
        $this->_descripcion = $data['adquisicion_detalle_descripcion'];
        $this->_cantidad = $data['adquisicion_detalle_cantidad'];
        $this->_precio = $data['adquisicion_detalle_precio'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'adquisicion_detalle_id' => $this->_id,
            'adquisicion_id' => $this->_adquisicionId,
            'adquisicion_detalle_nombre' => $this->_nombre,
            'adquisicion_detalle_descripcion' => $this->_descripcion,
            'adquisicion_detalle_cantidad' => $this->_cantidad,
            'adquisicion_detalle_precio' => $this->_precio,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = new Application_Model_AdquisicionDetalle;
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }

    public function update() {
        $service = new Application_Model_AdquisicionDetalle;
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = new Application_Model_AdquisicionDetalle;
        return $service->delete($id);
    }

    static function getAllSubcategoria() {
        $service = new Application_Model_AdquisicionDetalle();
        return $service->getAdquisicionDetalle();
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