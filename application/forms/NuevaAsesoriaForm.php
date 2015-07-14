<?php
class Application_Form_NuevaAsesoriaForm extends Core_Form {

    function init() {
        parent::init();
        
        $titulo = new Zend_Form_Element_Text('titulo');
        $titulo->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->setRequired(true);
        
        $descripcion = new Zend_Form_Element_Textarea('descripcion');
        $descripcion->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('rows', '10');
        
        $this->addElement($titulo)
                ->addElement($descripcion);

        $this->formatDecoratorCustom();
    }

    public function isValid($params) {
        return parent::isValid($params);
    }
}

