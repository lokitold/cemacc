<?php

class Core_Filter_Moneda implements Zend_Filter_Interface {

    public function filter($value) {
        
        return str_replace('S/.', '', $value);
    }

}
