<?php

class Core_Filter_ArrayKey {

    private $_key;
    private $_value;

    function __construct($key,$value) {
        $this->_key = $key;
        $this->_value = $value;
    }

    function esIgual($array) {
        return $array[$this->_key] == $this->_value;
    }
}
