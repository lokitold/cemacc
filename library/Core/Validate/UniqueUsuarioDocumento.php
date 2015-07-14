<?php

class Core_Validate_UniqueUsuarioDocumento extends Zend_Validate_Abstract {

    const MessageValidarUsuarioDocumento = 'UsuarioDocumentoNotUnique';

    protected $_messageTemplates = array(
        self::MessageValidarUsuarioDocumento => "El Documento ingresado ya esta en uso");

    function isValid($value, $context = null) {
        
        if (Application_Entity_Usuario::isDocumentoUnique($context['usuario'], $value,$context['tipoDocumento'])) {
            return true;
        } else {
            $this->_error(self::MessageValidarUsuarioDocumento);
            return false;
        }
    }

}