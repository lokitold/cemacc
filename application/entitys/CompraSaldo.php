<?php

class Application_Entity_CompraSaldo extends Core_Entity {

    protected $_id;
    protected $_empresa;
    protected $_paquete;
    protected $_fechaCompra;
    protected $_fechaConfirmacion;
    protected $_flagActivo;

    public function identify($id) {
        $service = $this->setService('CompraSaldo');
        $data = $service->getCompraSaldo($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['compra_saldo_id'];
        $this->_empresa = $data['empresa_id'];
        $this->_paquete = $data['paquete_id'];
        $this->_fechaCompra = $data['fecha_confirmacion'];
        $this->_fechaConfirmacion = $data['precio'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'compra_saldo_id' => $this->_id,
            'empresa_id' => $this->_empresa,
            'paquete_id' => $this->_paquete,
            'fecha_compra' => $this->_fechaCompra,
            'fecha_confirmacion' => $this->_fechaConfirmacion,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = self::setService('CompraSaldo');
        $fechaCompra = new Zend_Date();
        $this->_fechaCompra = $fechaCompra->get('YYYY-MM-dd HH:mm:ss');
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }
    
    static function confirmar($id){
        $service = self::setService('CompraSaldo');
        $data = array(
            'swt_activo' => '1',
        );
        return $service->update($id,$data);
    }
    
    public function prepareMail($html){
        $dataCorreo = Application_Entity_Usuario::getCorreosAdquisicion($this->_empresaEnvio);
        foreach ($dataCorreo as $correo){
            $this->sendAdquisicionMail($correo[usuario_email],$html);
        }
    }
            
    private function sendAdquisicionMail($email,$html){
        $mail = new Zend_Mail('UTF-8');
        $mail->setFrom(FRONT_MAIL_DEFAULT, 'CEMACC');
        $mail->addTo($email);
        $plantilla = file_get_contents(realpath(dirname(__FILE__) . '/email/adquisicionProductos.html'));;
        $plantilla = str_replace('[html]', $html, $plantilla);
        $plantilla = str_replace('width', '', $plantilla);
        $plantilla = str_replace('ancho', 'width', $plantilla);
        $mail->setSubject('Requerimiento de Productos');
        $mail->setBodyHtml($plantilla);
        $mail->send();
    }        

    public function update() {
        $service = self::setService('Adquisicion');
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = self::setService('Adquisicion');
        return $service->delete($id);
    }

    static function getAllCompraSaldo() {
        $service = new Application_Model_CompraSaldo();
        return $service->getCompraSaldo();
    }
    
    static function activar($id,$estado){
        $service = self::setService('Juzgado');
        $data = array(
            'juzgado_flag_activo' => $estado,
        );
        return $service->update($id,$data);
    }
    
}