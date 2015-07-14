<?php

class Core_Validate_ValidUsuarioEmail extends Zend_Validate_Abstract {

    const MessageValidUsuarioEmail = 'UsuarioEmailNotValid';

    protected $_messageTemplates = array(
        self::MessageValidUsuarioEmail => "El email ingresado no se encuentra registrado");

    
    function isValid($value, $context = null) {
        
        if (Application_Entity_Usuario::existEmail($value)) {
            return true;
        } else {
            $this->_error(self::MessageValidUsuarioEmail);
            return false;
        }
    }
}