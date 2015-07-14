<?php

class Application_Entity_Trainer extends Core_Entity {

    protected $_id;
    protected $_nombres;
    protected $_apellidos;
    protected $_descripcion;
    protected $_foto;
    protected $_flagActivo;

    public function identify($id) {
        $service = new Application_Model_Trainer();
        $data = $service->getTrainer($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['trainer_id'];
        $this->_nombres = $data['trainer_nombres'];
        $this->_apellidos = $data['trainer_apellidos'];
        $this->_descripcion = $data['trainer_descripcion'];
        $this->_foto = $data['trainer_foto'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'trainer_id' => $this->_id,
            'trainer_nombres' => $this->_nombres,
            'trainer_apellidos' => $this->_apellidos,
            'trainer_descripcion' => $this->_descripcion,
            'trainer_foto' => $this->_foto,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = new Application_Model_Trainer();
        $this->_id = $service->insert($this->setDataBaseProperties());

        return $this->_id;
    }

    public function update() {
        $service = new Application_Model_Trainer();
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = new Application_Model_Trainer();
        return $service->delete($id);
    }

    static function getAllTrainer() {
        $service = new Application_Model_Trainer();
        return $service->getTrainer();
    }
    
    static function getActivos() {
        $service = new Application_Model_Trainer();
        return $service->getTrainerActivos();
    }

    static function activar($id, $estado) {
        $service = new Application_Model_Trainer();
        $data = array(
            'swt_activo' => $estado,
        );
        return $service->update($id, $data);
    }

}
