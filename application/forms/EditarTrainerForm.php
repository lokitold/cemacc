<?php

class Application_Form_EditarTrainerForm extends Core_Form {

    function init() {
        parent::init();
        
        $trainer = new Zend_Form_Element_Hidden('trainer');
        $trainer->addValidator(new Zend_Validate_Digits())
                ->setRequired(true);

        $nombres = new Zend_Form_Element_Text('nombres');
        $nombres->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El nombre ingresado no es válido')));
        
        $apellidos = new Zend_Form_Element_Text('apellidos');
        $apellidos->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El nombre ingresado no es válido')));

        $file = new Zend_Form_Element_File('file');
        $file->setDestination(APPLICATION_PATH . '/../public/dinamic/trainer/')
                ->addValidator('IsImage', true)
                ->addValidator('Size', true, 1024000)
                ->setValueDisabled(true);

        $this->addElement($nombres)
                ->addElement($trainer)
                ->addElement($apellidos)
                ->addElement($file);

        $this->formatDecoratorCustom();
    }

    public function isValid($params) {
        return parent::isValid($params);
    }

}
