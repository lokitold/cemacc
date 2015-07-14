<?php

class Application_Entity_Ubicacion extends Core_Entity {

    protected $_id;
    protected $_pais;
    protected $_ubigeo;
    protected $_direccion;
    protected $_empresa;
    protected $_flagActivo;

    public function identify($id) {
        $service = new Application_Model_Ubicacion();
        $data = $service->getEmpresa($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    public function setPropertiesDataBase($array) {
        $this->_id = $array['ubicacion_id'];
        $this->_pais = $array['pais_id'];
        $this->_ubigeo = $array['ubigeo_id'];
        $this->_direccion = $array['ubicacion_direccion'];
        $this->_empresa = $array['empresa_id'];
        $this->_flagActivo = $array['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'ubicacion_id' => $this->_id,
            'pais_id' => $this->_pais,
            'ubigeo_id' => $this->_ubigeo,
            'ubicacion_direccion' => $this->_direccion,
            'empresa_id' => $this->_empresa,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = new Application_Model_Ubicacion();
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }

    public function update() {
        $service = new Application_Model_Ubicacion();
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = new Application_Model_Ubicacion();
        return $service->delete($id);
    }

}
