<?php

class Application_Entity_Requerimiento extends Core_Entity {

    protected $_id;
    protected $_empresaId;
    protected $_fechaLimite;
    protected $_fechaRegistro;
    protected $_empresaEnvio;
    protected $_flagActivo;

    public function identify($id) {
        $service = $this->setService('Requerimiento');
        $data = $service->getRequerimiento($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['requerimiento_id'];
        $this->_empresaId = $data['empresa_id'];
        $this->_fechaLimite = $data['requerimiento_fecha_limite'];
        $this->_fechaRegistro = $data['requerimiento_fecha_registro'];
        $this->_empresaEnvio = $data['requerimiento_empresa_envio'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'requerimiento_id' => $this->_id,
            'empresa_id' => $this->_empresaId,
            'requerimiento_fecha_limite' => $this->_fechaLimite,
            'requerimiento_fecha_registro' => $this->_fechaRegistro,
            'requerimiento_empresa_envio' => $this->_empresaEnvio,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = self::setService('Requerimiento');
        $fechaLimite = new Zend_Date($this->_fechaLimite);
        $this->_fechaLimite = $fechaLimite->get('YYYY-MM-dd HH:mm:ss');
        $fechaRegistro = new Zend_Date();
        $this->_fechaRegistro = $fechaRegistro->get('YYYY-MM-dd HH:mm:ss');
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }

    public function update() {
        $service = self::setService('Requerimiento');
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = self::setService('Requerimiento');
        return $service->delete($id);
    }

    static function getAllSubcategoria() {
        $service = new Application_Model_Requerimiento();
        return $service->getRequerimiento();
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