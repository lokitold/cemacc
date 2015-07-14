<?php

class Application_Entity_Usuario extends Core_Entity {

    const TIPO_DOCUMENTO_DNI_ID = 1;
    const TIPO_DOCUMENTO_CE_ID = 2;
    const TIPO_DOCUMENTO_RUC_ID = 3;
    const TIPO_DOCUMENTO_DNI_NOMBRE = 'DNI';
    const TIPO_DOCUMENTO_CE_NOMBRE = 'CE';
    const TIPO_DOCUMENTO_RUC_NOMBRE = 'RUC';

    protected $_id;
    protected $_usuario;
    protected $_password;
    protected $_hash;
    protected $_flagActivo;
    protected $_nombre;
    protected $_apellido;
    protected $_email;
    protected $_empresa;

    public function identify($id) {
        $service = $this->setService('Usuario');
        $data = $service->getUsuario($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }
    
    public function identifyByEmail($email){
        $service = $this->setService('Usuario');
        $data = $service->getByEmail($email, 0);
        $this->setPropertiesDataBase($data);
        return $data;
    }
    
    static function getTipoDocumentoNombre($tipoDocumento){
        $tipos = self::getTiposDocumento();
        return $tipos[$tipoDocumento]['nombre'];
    }

    static function getTiposDocumentoPersonaNatural() {
        return array(
            array('id' => self::TIPO_DOCUMENTO_DNI_ID, 'nombre' => self::TIPO_DOCUMENTO_DNI_NOMBRE),
            array('id' => self::TIPO_DOCUMENTO_CE_ID, 'nombre' => self::TIPO_DOCUMENTO_CE_NOMBRE),
        );
    }
    
    static function getTiposDocumento() {
        return array(
            self::TIPO_DOCUMENTO_DNI_ID => array('id' => self::TIPO_DOCUMENTO_DNI_ID, 'nombre' => self::TIPO_DOCUMENTO_DNI_NOMBRE),
            self::TIPO_DOCUMENTO_CE_ID => array('id' => self::TIPO_DOCUMENTO_CE_ID, 'nombre' => self::TIPO_DOCUMENTO_CE_NOMBRE),
            self::TIPO_DOCUMENTO_RUC_ID => array('id' => self::TIPO_DOCUMENTO_RUC_ID, 'nombre' => self::TIPO_DOCUMENTO_RUC_NOMBRE),
        );
    }
    
    public function setPropertiesDataBase($array) {
        $this->_id = $array['usuario_id'];
        $this->_usuario = $array['usuario_identity'];
        $this->_password = $array['usuario_password'];
        $this->_flagActivo = $array['swt_activo'];
        $this->_hash = $array['usuario_hash'];
        $this->_nombre = $array['usuario_nombre'];
        $this->_apellido = $array['usuario_apellido'];
        $this->_email = $array['usuario_email'];
        $this->_empresa = $array['empresa_id'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'usuario_id' => $this->_id,
            'usuario_identity' => $this->_usuario,
            'usuario_password' => $this->_password,
            'swt_activo' => $this->_flagActivo,
            'usuario_hash' => $this->_hash,
            'usuario_nombre' => $this->_nombre,
            'usuario_apellido' => $this->_apellido,
            'usuario_email' => $this->_email,
            'empresa_id' => $this->_empresa,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $password = Core_Utils::getRandomString(10,0);
        $hash = Core_Utils::getRandomString(10,0);
        $this->_password = Core_Auth_Adapter_ServiceDb::generatePassword($password);
        $this->_hash = Core_Auth_Adapter_ServiceDb::generatePassword($hash);
        $service = $this->setService('Usuario');
        $this->_id = $service->insert($this->setDataBaseProperties());
        if ($this->_id){
            $this->sendRegistrationMail(
                    $this->_nombre.' '.$this->_apellido,
                    $this->_usuario,$password,$this->_email);
        }
        return $this->_id;
    }
         
    /**
     * @return boolean true|false Si el proceso se realizo correctamente
     * @author Diego Lopez
     */
    public function enviarEmailRecuperarContrasena($email){
        $model = new Application_Model_Usuario();
        $dataUsuario = $model->getUsuarioByEmail($email);
        if (empty($dataUsuario)){
            $this->setMessage('El correo ingresado no se encuentra registrado en el sistema');
            return false;
        }
        $this->setPropertiesDataBase($dataUsuario);
        $password = Core_Utils::getRandomString(10,0);
        $this->_password = Core_Auth_Adapter_ServiceDb::generatePassword($password);
        if ($this->update()){
            $this->sendRecuperarContrasenaMail($email,$dataUsuario['implicado_nombre']. ' '. $dataUsuario['implicado_apellido_paterno'],$password);
            return true;
        }else{
            $this->setMessage('Hubo un problema al recuperar su contraseña, inténtelo nuevamente');
            return false;
        }        
    }
    
    /**
     * @param string $email Email al cual enviar el correo con las credenciales
     * @param string $nombre Nombres y Apellidos del usuario del sistema
     * @param string $password Nuevo Password
     * @return boolean true|false Si el correo se ha enviado correctamente
     * @author Diego Lopez
     */
    private function sendRecuperarContrasenaMail($email, $nombres,$password){
        $objPlantilla = new Application_Entity_Plantilla();
        $objPlantilla->identify(Application_Entity_Plantilla::RECUPERAR_CONTRASENA);
        $mail = new Zend_Mail('UTF-8');
        $mail->setFrom(FRONT_MAIL_DEFAULT, 'BitMinds Consultors');
        $mail->addTo($email, $nombres);
        $plantilla = file_get_contents(realpath(dirname(__FILE__) . '/email/recuperacionContrasena.html'));
        $plantilla = str_replace('[abogado]', $nombres, $plantilla);
        $plantilla = str_replace('[usuario]', $this->_usuario, $plantilla);
        $plantilla = str_replace('[password]', $password, $plantilla);
        $plantilla = str_replace('[url]', BASE_URL, $plantilla);
        $mail->setSubject('Recuperación de Contraseña');
        $mail->setBodyHtml($plantilla);
        $mail->send();
    }
    
     private function sendRegistrationMail($nombre,$usuario,$password,$email){
        $mail = new Zend_Mail('UTF-8');
        $mail->setFrom(FRONT_MAIL_DEFAULT, 'CEMACC');
        $mail->addTo($email,$nombre);
        $plantilla = file_get_contents(realpath(dirname(__FILE__) . '/email/nuevoUsuario.html'));;
        $plantilla = str_replace('[nombre]', $nombre, $plantilla);
        $plantilla = str_replace('[usuario]', $usuario, $plantilla);
        $plantilla = str_replace('[password]', $password, $plantilla);
        $plantilla = str_replace('[url]', BASE_URL, $plantilla);
        $mail->setSubject('Nuevo Usuario');
        $mail->setBodyHtml($plantilla);
        $mail->send();
    }

    public function update() {
        $model = new Application_Model_Usuario();
        if ($model->update($this->_id, $this->setDataBaseProperties()) !== false){
            return true;
        }else{
            $this->setMessage('Hubo un error al actualizar sus datos, inténtelo nuevamente');
            return false;
        }
    }
    
    static function activar($id,$estado){
        $service = self::setService('Usuario');
        $data = array(
            'usuario_flag_activo' => $estado,
        );
        return $service->update($id,$data);
    }
    
    static function insertUsuarioRole($data) {
        $service = self::setService('Usuario');
        return $service->insertUsuarioRole($data);
    }
    
    public function login($usuario, $password) {
        $auth = Zend_Auth::getInstance();
        $adapter = new Core_Auth_Adapter_ServiceDb();
        $adapter->setIdentity($usuario);
        $adapter->setCredential($password);
        $result = $auth->authenticate($adapter);
        $resultBool = $result->isValid();
        
        if ($resultBool) {
            echo 'todo ok';
            $data = $adapter->getResultRowObject(null, 'usuario_password');
            $auth->getStorage()->write($data);
        }
        return $resultBool;
    }

    static function getAllUsuarios() {
        $service = self::setService('Usuario');
        $data = $service->getUsuario('',1);
        return $data;
    }
    
    static function getCorreosAdquisicion($n) {
        $service = self::setService('Usuario');
        $data = $service->getCorreosAdquisicion($n);
        return $data;
    }

    static function getRoles() {
        $service = Core_Entity::setService('Usuario');
        return $service->getRoles();
    }
    
    static function getModuleByUsuario($usuario) {
        $service = Core_Entity::setService('Usuario');
        return $service->getModuleByUsuario($usuario);
    }

    static function getPermissions() {
        $service = Core_Entity::setService('Usuario');
        return $service->getPermissions();
    }

    static function getResources() {
        $service = Core_Entity::setService('Usuario');
        return $service->getResources();
    }

    static function isEmailUnique($id, $email) {
        $service = self::setService('Usuario');
        $result = $service->getByEmail($email, $id);
        return empty($result);
    }

    static function isLoginUnique($id, $login) {
        $service = self::setService('Usuario');
        $result = $service->getByLogin($login, $id);
        return empty($result);
    }
    
    /**
     * @param string $email El email ha validar si existe
     * @return boolean true|false si el email existe
     * @author Diego Lopez
     */
    static function existEmail($email){
        $model = new Application_Model_Usuario();
        $result = $model->getAbogadoByEmail($email);
        return !empty($result);
    }
    
    static function checkHashPassword($user,$hash){
        $service = self::setService('Usuario');
        $result = $service->checkHashPassword($user,$hash);
        return !empty($result);
    }
    
    static function recuperarContrasena($user,$hash,$password){
        $bpassword = Core_Auth_Adapter_ServiceDb::generatePassword($password);
        $newhash = Core_Auth_Adapter_ServiceDb::generatePassword(Core_Utils::getRandomString(10,0));
        $service = self::setService('Usuario');
        return $service->recuperarContrasena($user,$hash,$bpassword,$newhash);
    }
    
    /**
     * @param string $implicado Usuario a evaluar password
     * @param string $password password a evaluar
     * @return boolean true si usuario/password coincide con bd
     * @author Diego Lopez
     */
    static function checkPassword($implicado,$password){
        $model = new Application_Model_Usuario();
        $result = $model->getUsuarioByImplicado($implicado);
        if (empty($result)){
            return false;
        }
        return Core_Auth_Adapter_ServiceDb::checkPassword($password, $result['usuario_password']);
    }
    
    static function isDocumentoUnique($usuario,$numDoc,$tipoDoc){
        $data = self::setService('Usuario')->getByDocumento($usuario,$numDoc,$tipoDoc);
        return empty($data);
    }
    
    
    public function actualizarContrasena(){
        $this->_password = Core_Auth_Adapter_ServiceDb::generatePassword($this->_password);
        return $this->update();
    }
}