<?php

class Application_Entity_Empresa extends Core_Entity {

    protected $_id;
    protected $_nombreComercial;
    protected $_razonSocial;
    protected $_ruc;
    protected $_website;
    protected $_idCategoria;
    protected $_idSubcategoria;
    protected $_imagen;
    protected $_logo;
    protected $_flagActivo;

    public function identify($id) {
        $service = new Application_Model_Empresa();
        $data = $service->getEmpresa($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    public function setPropertiesDataBase($array) {
        $this->_id = $array['empresa_id'];
        $this->_nombreComercial = $array['empresa_nombre_comercial'];
        $this->_razonSocial = $array['empresa_razon_social'];
        $this->_ruc = $array['empresa_ruc'];
        $this->_website = $array['empresa_website'];
        $this->_idCategoria = $array['categoria_id'];
        $this->_idSubcategoria = $array['subcategoria_id'];
        $this->_imagen = $array['empresa_imagen'];
        $this->_logo = $array['empresa_logo'];
        $this->_flagActivo = $array['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'empresa_id' => $this->_id,
            'empresa_nombre_comercial' => $this->_nombreComercial,
            'empresa_razon_social' => $this->_razonSocial,
            'empresa_ruc' => $this->_ruc,
            'empresa_website' => $this->_website,
            'categoria_id' => $this->_idCategoria,
            'subcategoria_id' => $this->_idSubcategoria,
            'empresa_imagen' => $this->_imagen,
            'empresa_logo' => $this->_logo,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = new Application_Model_Empresa();
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }

    public function update() {
        $service = new Application_Model_Empresa();
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = new Application_Model_Empresa();
        return $service->delete($id);
    }

    static function getAllEmpresa() {
        $service = new Application_Model_Empresa();
        return $service->getEmpresa();
    }

    static function getLogos() {
        $service = new Application_Model_Empresa();
        return $service->getLogosEmpresa();
    }

    static function getEmpresaByCategoria($id) {
        $service = new Application_Model_Empresa();
        return $service->getEmpresaByCategoria($id);
    }

    public function autocompleteEmpresas($val) {
        $model = new Application_Model_Empresa();
        $val = "%" . $val . "%";
        return $model->autocompleteEmpresas($val);
    }

    static function activar($id, $estado) {
        $service = new Application_Model_Empresa();
        $data = array(
            'swt_activo' => $estado,
        );
        return $service->update($id, $data);
    }

}
