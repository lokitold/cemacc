<?php

class Application_Form_Validators_UniqueUsuarioLogin extends Zend_Validate_Abstract {

    const MessageValidarUsuarioLogin = 'UsuarioLoginNotUnique';

    protected $_messageTemplates = array(
        self::MessageValidarUsuarioLogin => "El usuario ingresado ya está en uso");

    function isValid($value, $context = null) {

        if (Application_Entity_Usuario::isLoginUnique($context['usuario'], $value)) {
            return true;
        } else {
            $this->_error(self::MessageValidarUsuarioLogin);
            return false;
        }
    }

}