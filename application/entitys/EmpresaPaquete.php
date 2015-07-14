<?php

class Application_Entity_EmpresaPaquete extends Core_Entity {

    protected $_id;
    protected $_empresa;
    protected $_paquete;
    protected $_saldo;

    public function identify($id) {
        $service = $this->setService('EmpresaPaquete');
        $data = $service->getAdquisicion($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['empresa_paquete_id'];
        $this->_empresa = $data['empresa_id'];
        $this->_paquete = $data['paquete_id'];
        $this->_saldo = $data['dias_saldo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'empresa_paquete_id' => $this->_id,
            'empresa_id' => $this->_empresa,
            'paquete_id' => $this->_paquete,
            'dias_saldo' => $this->_saldo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = self::setService('Adquisicion');
        $fechaLimite = new Zend_Date($this->_fechaLimite);
        $this->_fechaLimite = $fechaLimite->get('YYYY-MM-dd HH:mm:ss');
        $fechaRegistro = new Zend_Date();
        $this->_fechaRegistro = $fechaRegistro->get('YYYY-MM-dd HH:mm:ss');
        $this->_id = $service->insert($this->setDataBaseProperties());
        
        return $this->_id;
    }

    public function update() {
        $service = self::setService('Adquisicion');
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = self::setService('Adquisicion');
        return $service->delete($id);
    }

    static function getSaldoByEmpresa($empresa) {
        $service = new Application_Model_EmpresaPaquete();
        return $service->getEmpresaPaqueteByEmpresa($empresa);
    }
    

}