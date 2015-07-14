<?php

class Application_Entity_Adquisicion extends Core_Entity {

    protected $_id;
    protected $_tipo;
    protected $_empresaId;
    protected $_fechaLimite;
    protected $_fechaRegistro;
    protected $_empresaEnvio;
    protected $_flagActivo;

    public function identify($id) {
        $service = $this->setService('Adquisicion');
        $data = $service->getAdquisicion($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['adquisicion_id'];
        $this->_tipo = $data['adquisicion_tipo'];
        $this->_empresaId = $data['empresa_id'];
        $this->_fechaLimite = $data['adquisicion_fecha_limite'];
        $this->_fechaRegistro = $data['adquisicion_fecha_registro'];
        $this->_empresaEnvio = $data['adquisicion_empresa_envio'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'adquisicion_id' => $this->_id,
            'adquisicion_tipo' => $this->_tipo,
            'empresa_id' => $this->_empresaId,
            'adquisicion_fecha_limite' => $this->_fechaLimite,
            'adquisicion_fecha_registro' => $this->_fechaRegistro,
            'adquisicion_empresa_envio' => $this->_empresaEnvio,
            'swt_activo' => $this->_flagActivo,
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

    static function getAllSubcategoria() {
        $service = new Application_Model_Adquisicion();
        return $service->getAdquisicion();
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
    
    static function getAdquisicionByEmpresa($empresa){
        $service = new Application_Model_Adquisicion();
        return $service->getAdquisicionByEmpresa($empresa);
    }


}