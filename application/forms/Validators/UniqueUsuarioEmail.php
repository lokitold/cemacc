<?php

class Application_Form_Validators_UniqueUsuarioEmail extends Zend_Validate_Abstract {

    const MessageValidarUsuarioEmail = 'UsuarioEmailNotUnique';

    protected $_messageTemplates = array(
        self::MessageValidarUsuarioEmail => "El email ingresado ya está en uso");

    function isValid($value, $context = null) {


        $usuario = (isset($context['usuario'])) ? ($context['usuario']) : 0;
        if (Application_Entity_Usuario::isEmailUnique($usuario, $value)) {

            return true;
        } else {
            $this->_error(self::MessageValidarUsuarioEmail);
            return false;
        }
    }

}