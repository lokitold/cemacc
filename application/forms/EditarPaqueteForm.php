<?php

class Application_Form_EditarPaqueteForm extends Core_Form {

    function init() {
        parent::init();

        $paquete = new Zend_Form_Element_Hidden('paquete');
        $paquete->addValidator(new Zend_Validate_Digits())
                ->setRequired(true);

        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->setRequired(true);

        $dias = new Zend_Form_Element_Text('dias');
        $dias->addFilter(new Zend_Filter_HtmlEntities())
                ->setRequired(true)
                ->setAttribs(array('class' => 'input-sm'))
                ->addFilter('StringTrim');

        $precio = new Zend_Form_Element_Text('precio');
        $precio->addFilter(new Zend_Filter_HtmlEntities())
                ->setRequired(true)
                ->setAttribs(array('class' => 'input-sm'))
                ->addFilter('StringTrim');

        $dimension = new Zend_Form_Element_Text('dimension');
        $dimension->addFilter(new Zend_Filter_HtmlEntities())
                ->setRequired(true)
                ->setAttribs(array('class' => 'input-sm'))
                ->addFilter('StringTrim');


        $this->addElement($nombre)
                ->addElement($dias)
                ->addElement($paquete)
                ->addElement($precio)
                ->addElement($dimension);

        $this->formatDecoratorCustom();
    }

    public function isValid($params) {
        return parent::isValid($params);
    }

}
