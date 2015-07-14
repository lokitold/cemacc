<?php

class Application_Entity_Paquete extends Core_Entity {

    protected $_id;
    protected $_nombre;
    protected $_dias;
    protected $_precio;
    protected $_dimension;
    protected $_flagActivo;

    public function identify($id) {
        $service = new Application_Model_Paquete();
        $data = $service->getPaquete($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['paquete_id'];
        $this->_nombre = $data['paquete_nombre'];
        $this->_dias = $data['paquete_dias'];
        $this->_precio = $data['paquete_precio'];
        $this->_dimension = $data['paquete_dimension'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'paquete_id' => $this->_id,
            'paquete_nombre' => $this->_nombre,
            'paquete_dias' => $this->_dias,
            'paquete_precio' => $this->_precio,
            'paquete_dimension' => $this->_dimension,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = new Application_Model_Paquete();
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }

    public function prepareMail($html) {
        $dataCorreo = Application_Entity_Usuario::getCorreosAdquisicion($this->_empresaEnvio);
        foreach ($dataCorreo as $correo) {
            $this->sendAdquisicionMail($correo[usuario_email], $html);
        }
    }

    private function sendAdquisicionMail($email, $html) {
        $mail = new Zend_Mail('UTF-8');
        $mail->setFrom(FRONT_MAIL_DEFAULT, 'CEMACC');
        $mail->addTo($email);
        $plantilla = file_get_contents(realpath(dirname(__FILE__) . '/email/adquisicionProductos.html'));
        ;
        $plantilla = str_replace('[html]', $html, $plantilla);
        $plantilla = str_replace('width', '', $plantilla);
        $plantilla = str_replace('ancho', 'width', $plantilla);
        $mail->setSubject('Requerimiento de Productos');
        $mail->setBodyHtml($plantilla);
        $mail->send();
    }

    public function update() {
        $service = new Application_Model_Paquete();
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = self::setService('Adquisicion');
        return $service->delete($id);
    }

    static function getAllPaquete() {
        $service = new Application_Model_Paquete();
        return $service->getPaquete();
    }

    static function activar($id, $estado) {
        $service = new Application_Model_Paquete();
        $data = array(
            'swt_activo' => $estado,
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
