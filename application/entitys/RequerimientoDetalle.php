<?php

class Application_Entity_RequerimientoDetalle extends Core_Entity {

    protected $_id;
    protected $_requerimientoId;
    protected $_puesto;
    protected $_funciones;
    protected $_sueldo;
    protected $_localidad;
    protected $_duracion;
    protected $_tipoTrabajo;
    protected $_contacto;
    protected $_correo;
    protected $_flagActivo;

    public function identify($id) {
        $service = $this->setService('RequerimientoDetalle');
        $data = $service->getRequerimientoDetalle($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['requerimiento_detalle_id'];
        $this->_requerimientoId = $data['requerimiento_id'];
        $this->_puesto = $data['requerimiento_detalle_puesto'];
        $this->_funciones = $data['requerimiento_detalle_funciones'];
        $this->_sueldo = $data['requerimiento_detalle_sueldo'];
        $this->_localidad = $data['requerimiento_detalle_localidad'];
        $this->_duracion = $data['requerimiento_detalle_duracion'];
        $this->_tipoTrabajo = $data['requerimiento_detalle_tipo_trabajo'];
        $this->_contacto = $data['requerimiento_detalle_contacto'];
        $this->_correo = $data['requerimiento_detalle_correo'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'requerimiento_detalle_id' => $this->_id,
            'requerimiento_id' => $this->_requerimientoId,
            'requerimiento_detalle_puesto' => $this->_puesto,
            'requerimiento_detalle_funciones' => $this->_funciones,
            'requerimiento_detalle_sueldo' => $this->_sueldo,
            'requerimiento_detalle_localidad' => $this->_localidad,
            'requerimiento_detalle_duracion' => $this->_duracion,
            'requerimiento_detalle_tipo_trabajo' => $this->_tipoTrabajo,
            'requerimiento_detalle_contacto' => $this->_contacto,
            'requerimiento_detalle_correo' => $this->_correo,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = self::setService('RequerimientoDetalle');
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }

    public function update() {
        $service = self::setService('RequerimientoDetalle');
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = self::setService('RequerimientoDetalle');
        return $service->delete($id);
    }

    static function getAllSubcategoria() {
        $service = new Application_Model_RequerimientoDetalle();
        return $service->getRequerimientoDetalle();
    }

    static function activar($id, $estado) {
        $service = self::setService('Juzgado');
        $data = array(
            'juzgado_flag_activo' => $estado,
        );
        return $service->update($id, $data);
    }

    static function getSubcategoriaByCategoria($id) {
        $service = new Application_Model_Subcategoria();
        return $service->getSubcategoriaByCategoria($id);
    }

}
