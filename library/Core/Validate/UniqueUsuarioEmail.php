<?php

class Core_Validate_UniqueUsuarioEmail extends Zend_Validate_Abstract {

    const MessageValidarUsuarioEmail = 'UsuarioEmailNotUnique';

    protected $_messageTemplates = array(
        self::MessageValidarUsuarioEmail => "El email ingresado ya está en uso");

    
    function isValid($value, $context = null) {
        
        if (Application_Entity_Usuario::isEmailUnique($context['usuario'], $value)) {
            return true;
        } else {
            $this->_error(self::MessageValidarUsuarioEmail);
            return false;
        }
    }

}