<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entitys
 *
 * @author Laptop
 */
abstract class Core_Entity {

    protected $_message;
    //put your code here
    /////////////////// Inicio Funciones Rest para el consumo de las APIs  //////////////////////////////
    private $_parameters;
    
    const ESTADO_ACTIVO=1;
    const ESTADO_DESACTIVO=0;


    function __construct() {
        $this->_parameters = array();
        $this->_cache = Zend_Registry::get('cache');
    }

    protected function setParametersMethod($parameters) {
        $this->_parameters = $parameters;
    }

    public function setMessage($message) {
        $this->_message = $message;
    }
    public function getMessage() {
        return $this->_message;
    }

    /////////////////// Fin Funciones Rest para el consumo de las APIs  //////////////////////////////


    protected function init($data = null) {
        if ($data != NULL && is_array($data)) {
            $propsFormat = $this->setFormatProperti();
            foreach ($data as $index => $value) {
                if (in_array($index, $propsFormat)) {
                    $this->$index = $value;
                } else {
                    trigger_error('El Key <b>"' . $index . '"</b> no coinciden con las propiedades de la clase ', E_USER_ERROR);
                    exit;
                }
            }
        }
    }

    function setFormatProperti() {
        $cl = new ReflectionClass($this);
        $props = $cl->getProperties(ReflectionProperty::IS_PROTECTED);
        foreach ($props as $prop) {
            $propsFormat[] = $prop->getName();
        }
        return $propsFormat;
    }

    function setPropertie($properti, $value) {
        $propsFormat = $this->setFormatProperti();
        if (in_array($properti, $propsFormat)) {
            $this->$properti = $value;
        } else {
            trigger_error('El Key <b>"' . $index . '"</b> no coinciden con las propiedades de la clase ', E_USER_ERROR);
            exit;
        }
    }

    function setProperties($array) {
        $this->init($array);
    }

    function getProperties() {
        $cl = new ReflectionClass($this);
        $props = $cl->getProperties(ReflectionProperty::IS_PROTECTED);
        foreach ($props as $prop) {
            $propsFormat[$prop->getName()] = $this->{$prop->getName()};
        }
        return $propsFormat;
    }

    protected function cleanArray($data) {
        foreach ($data as $index => $value) {
            if ($value === '' ||$value == '') {
                unset($data[$index]);
            } else {
                if ($value == 'NULL') {
                    $data[$index] = '';
                }
            }
        }
        return $data;
    }

    function getPropertie($propertie) {
        if (property_exists($this, $propertie)) {
            return $this->{$propertie};
        } else {
            return false;
        }
    }
    
    static function setService($service) {
        $class = 'Application_Model_' . ucwords($service);
        return new $class();
    }

}

?>
