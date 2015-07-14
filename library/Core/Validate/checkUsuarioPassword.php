<?php

class Core_Validate_checkUsuarioPassword extends Zend_Validate_Abstract {

    const MessageCheckUsuarioPassword = 'UsuarioEmailNotUnique';

    protected $_messageTemplates = array(
        self::MessageCheckUsuarioPassword => "La contraseña ingresada no es correcta");

    
    function isValid($value, $context = null) {
        if (Application_Entity_Usuario::checkPassword($context['usuario'], $value)) {
            return true;
        } else {
            $this->_error(self::MessageCheckUsuarioPassword);
            return false;
        }
    }
}