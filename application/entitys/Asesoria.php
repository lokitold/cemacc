<?php

class Application_Entity_Asesoria extends Core_Entity {

    protected $_id;
    protected $_titulo;
    protected $_descripcion;
    protected $_imagen;
    protected $_fechaRegistro;
    protected $_flagActivo;

    public function identify($id) {
        $service = new Application_Model_Asesoria();
        $data = $service->getAsesoria($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['asesoria_id'];
        $this->_titulo = $data['asesoria_titulo'];
        $this->_descripcion = $data['asesoria_descripcion'];
        $this->_imagen = $data['asesoria_imagen'];
        $this->_fechaRegistro = $data['asesoria_fecha_registro'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'asesoria_id' => $this->_id,
            'asesoria_titulo' => $this->_titulo,
            'asesoria_descripcion' => $this->_descripcion,
            'asesoria_imagen' => $this->_imagen,
            'asesoria_fecha_registro' => $this->_fechaRegistro,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = new Application_Model_Asesoria();
        $fechaRegistro = new Zend_Date();
        $this->_fechaRegistro = $fechaRegistro->get('YYYY-MM-dd HH:mm:ss');
        $this->_id = $service->insert($this->setDataBaseProperties());

        return $this->_id;
    }

    public function update() {
        $service = new Application_Model_Asesoria();
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = new Application_Model_Asesoria();
        return $service->delete($id);
    }

    static function getAllAsesoria() {
        $service = new Application_Model_Asesoria();
        return $service->getAsesoria();
    }

    static function activar($id, $estado) {
        $service = new Application_Model_Asesoria();
        $data = array(
            'swt_activo' => $estado,
        );
        return $service->update($id, $data);
    }

}
