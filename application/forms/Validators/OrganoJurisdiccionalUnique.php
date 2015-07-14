<?php
class Application_Form_Validators_OrganoJurisdiccionalUnique extends Zend_Validate_Abstract{
    const MessageValidarOrganoJurisdiccional = '';
    
    protected $_messageTemplates = array(
        self::MessageValidarOrganoJurisdiccional => "El Nombre '%value%' ya se encuentra registrado");
    function isValid($value) {
        
        if(!Application_Entity_OrganoJurisdiccional::nombreExist($value)){ 
            return true;
        }else{
            $this->_error(self::MessageValidarOrganoJurisdiccional,$value);
            return false;
        }
    
    }
}

