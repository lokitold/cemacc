<?php

class Application_Form_NuevoBoletinForm extends Core_Form {

    function init() {
        parent::init();


        $fecha = new Zend_Form_Element_Text('fecha');
        $fecha->setRequired()
                ->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('class', 'fecha')
                ->addValidator(new Zend_Validate_Date(array('format' => 'dd/MM/YYYY')));

        $file = new Zend_Form_Element_File('file');
        $file->setDestination(APPLICATION_PATH . '/../public/dinamic/boletin/')
                ->setRequired()
                ->addValidator('Size', true, 1024000)
                ->setValueDisabled(true);

        $portada = new Zend_Form_Element_File('portada');
        $portada->setDestination(APPLICATION_PATH . '/../public/dinamic/boletin/')
                ->addValidator('IsImage', true)
                ->setRequired()
                ->addValidator('Size', true, 1024000)
                ->setValueDisabled(true);

        $this->addElement($fecha)
                ->addElement($file)
                ->addElement($portada);

        $this->formatDecoratorCustom();
    }

    

}
