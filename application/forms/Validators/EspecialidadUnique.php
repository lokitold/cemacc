<?php

class Application_Form_Validators_EspecialidadUnique extends Zend_Validate_Abstract {

    const MessageValidarEspecialidad = '';

    protected $_messageTemplates = array(
        self::MessageValidarEspecialidad => "El Nombre '%value%' ya se encuentra registrado");

    function isValid($value) {

        if (!Application_Entity_Especialidad::nombreExist($value)) {
            return true;
        } else {
            $this->_error(self::MessageValidarEspecialidad, $value);
            return false;
        }
    }

}

