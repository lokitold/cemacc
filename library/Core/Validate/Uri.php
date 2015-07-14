<?php

class Core_Validate_Uri extends Zend_Validate_Abstract
{
    const INVALID = 'URIInvalid';
 
    protected $_messageTemplates = array(
        self::INVALID => "'%value%' no es valido la URL"
    );
 
    public function isValid($value)
    {
        if (empty($value)) return true;
 
        if(!@file_get_contents($value)){
            $this->_error(self::INVALID);
            return false;
        }
        if (!Zend_Uri::check($value)) {
            $this->_error(self::INVALID);
            return false;
        }
 
        return true;
    }
 
}