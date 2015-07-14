<?php

class Application_Entity_Boletin extends Core_Entity {

    protected $_id;
    protected $_fecha;
    protected $_url;
    protected $_portada;
    protected $_flagActivo;

    public function identify($id) {
        $service = new Application_Model_Boletin();
        $data = $service->getBoletin($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['boletin_id'];
        $this->_fecha = $data['boletin_fecha'];
        $this->_url = $data['boletin_url'];
        $this->_portada = $data['boletin_portada'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'boletin_id' => $this->_id,
            'boletin_fecha' => $this->_fecha,
            'boletin_url' => $this->_url,
            'boletin_portada' => $this->_portada,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = new Application_Model_Boletin();
        $fecha = new Zend_Date($this->_fecha);
        $this->_fecha = $fecha->get('YYYY-MM-dd');
        $this->_id = $service->insert($this->setDataBaseProperties());

        return $this->_id;
    }

    public function update() {
        $service = new Application_Model_Boletin();
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = new Application_Model_Boletin();
        return $service->delete($id);
    }

    static function getAllBoletin() {
        $service = new Application_Model_Boletin();
        return $service->getBoletin();
    }

}
