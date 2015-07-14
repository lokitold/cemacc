<?php

class Application_Entity_Capacitacion extends Core_Entity {

    protected $_id;
    protected $_titulo;
    protected $_imagen;
    protected $_fechaRegistro;
    protected $_presentacion;
    protected $_beneficios;
    protected $_contenido;
    protected $_info;
    protected $_fecha;
    protected $_asiste;
    protected $_trainer;
    protected $_flagActivo;

    public function identify($id) {
        $service = new Application_Model_Capacitacion();
        $data = $service->getCapacitacion($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['capacitacion_id'];
        $this->_titulo = $data['capacitacion_titulo'];
        $this->_imagen = $data['capacitacion_imagen'];
        $this->_fechaRegistro = $data['capacitacion_fecha_registro'];
        $this->_presentacion = $data['capacitacion_presentacion'];
        $this->_beneficios = $data['capacitacion_beneficios'];
        $this->_contenido = $data['capacitacion_contenido'];
        $this->_info = $data['capacitacion_info_general'];
        $this->_fecha = $data['capacitacion_fecha'];
        $this->_asiste = $data['capacitacion_asiste'];
        $this->_trainer = $data['trainer_id'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'capacitacion_id' => $this->_id,
            'capacitacion_titulo' => $this->_titulo,
            'capacitacion_imagen' => $this->_imagen,
            'capacitacion_fecha_registro' => $this->_fechaRegistro,
            'capacitacion_presentacion' => $this->_presentacion,
            'capacitacion_beneficios' => $this->_beneficios,
            'capacitacion_contenido' => $this->_contenido,
            'capacitacion_info_general' => $this->_info,
            'capacitacion_fecha' => $this->_fecha,
            'capacitacion_asiste' => $this->_asiste,
            'trainer_id' => $this->_trainer,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = new Application_Model_Capacitacion();
        $fechaRegistro = new Zend_Date();
        $fecha = new Zend_Date($this->_fecha, 'dd-MM-YYYY');
        $this->_fechaRegistro = $fechaRegistro->get('YYYY-MM-dd HH:mm:ss');
        $this->_fecha = $fecha->get('YYYY-MM-dd');
        $this->_id = $service->insert($this->setDataBaseProperties());

        return $this->_id;
    }

    public function update() {
        $service = new Application_Model_Capacitacion();
        $fecha = new Zend_Date($this->_fecha, 'dd-MM-YYYY');
        $this->_fecha = $fecha->get('YYYY-MM-dd');
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = new Application_Model_Capacitacion();
        return $service->delete($id);
    }

    static function getAllCapacitacion() {
        $service = new Application_Model_Capacitacion();
        return $service->getCapacitacion();
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

    static function getAdquisicionByEmpresa($empresa) {
        $service = new Application_Model_Adquisicion();
        return $service->getAdquisicionByEmpresa($empresa);
    }

}
