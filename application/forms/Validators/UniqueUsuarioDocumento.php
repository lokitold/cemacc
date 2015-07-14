<?php

class Application_Form_Validators_UniqueUsuarioDocumento extends Zend_Validate_Abstract {

    const MessageValidarUsuarioDocumento = 'UsuarioDocumentoNotUnique';

    protected $_messageTemplates = array(
        self::MessageValidarUsuarioDocumento => "El Documento ingresado ya esta en uso");

    function isValid($value, $context = null) {



        $usuario = (isset($context['usuario']))? $context['usuario'] : 0;
        if (Application_Entity_Usuario::isDocumentoUnique(
                $usuario, 
                $value,
                $context['tipoDocumento'])) {

            return true;
        } else {
            $this->_error(self::MessageValidarUsuarioDocumento);
            return false;
        }
    }

}