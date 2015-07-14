<?php
class Application_Form_Validators_DistritoJudicialUnique extends Zend_Validate_Abstract{
    const MessageValidarDistritoJudicial = '';
    
    protected $_messageTemplates = array(
        self::MessageValidarDistritoJudicial => "El Nombre '%value%' ya se encuentra registrado");
    function isValid($value) {
        
        if(!Application_Entity_DistritoJudicial::nombreExist($value)){ 
            return true;
        }else{
            $this->_error(self::MessageValidarDistritoJudicial,$value);
            return false;
        }
    
    }
}

