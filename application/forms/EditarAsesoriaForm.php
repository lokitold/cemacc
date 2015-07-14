<?php

class Application_Form_EditarAsesoriaForm extends Core_Form {

    function init() {
        parent::init();

        $asesoria = new Zend_Form_Element_Hidden('asesoria');
        $asesoria->addValidator(new Zend_Validate_Digits())
                ->setRequired(true);

        $titulo = new Zend_Form_Element_Text('titulo');
        $titulo->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->setRequired(true);

        $descripcion = new Zend_Form_Element_Textarea('descripcion');
        $descripcion->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('rows', '10');

        $this->addElement($titulo)
                ->addElement($asesoria)
                ->addElement($descripcion);

        $this->formatDecoratorCustom();
    }

    public function isValid($params) {
        return parent::isValid($params);
    }

}
