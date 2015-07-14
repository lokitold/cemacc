<?php

class Application_Form_NuevoRol extends Core_Form {

    function init() {
        parent::init();
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->addFilter('StringTrim')
                ->setRequired(true)
                ->setAttrib('maxlength', 45)
                ->addValidator(new Zend_Validate_Alpha(true))
                ->addValidator(new Core_Validate_UniqueRolNombre())
                ->addValidator('stringLength', true, array(0, 45));
        
        $descripcion = new Zend_Form_Element_Textarea('descripcion');
        $descripcion->addFilter('StringTrim')
                ->setRequired(true)
                
                ->setAttrib('maxlength', 100)
                ->setAttrib('rows', 4)
                ->setAttrib('cols', 10)
                ->addValidator('stringLength', true, array(0, 100));
        
        $resource = new Zend_Form_Element_Hidden('resourceHiden');
        $resource->setValue(1);
        $activo = new Zend_Form_Element_Checkbox('activo');
        $activo->setAttrib('value', 1);
        $this->addElement($nombre)
                ->addElement($descripcion)
                ->addElement($resource)
                ->addElement($activo);
        $this->formatDecoratorCustom();
    }
    function isValid($data) {
        if (parent::isValid($data)) {
            if (isset($data['resource']) && is_array($data['resource']) && count($data['resource']) > 0) {
                return true;
            } else {
                //$this->getElement('resource')->addErrorMessage('De de tener al menos un elemento seleccionado');
                $this->getElement('resourceHiden')->addError('De de tener al menos un elemento seleccionado');
                return false;
            }
        }
    }

}
