<?php

class Application_Form_NuevoRequerimientoRecursosHumanosForm extends Core_Form {

    function init() {
        parent::init();
        $this->setMethod('Post');

        $puesto = new Zend_Form_Element_Text('puesto');
        $puesto->addFilter('StringTrim')
                ->setRequired(true);
        
        $funcion = new Zend_Form_Element_Textarea('funcion');
        $funcion->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('rows', '5')
                ->setRequired(true);
        
        $sueldo = new Zend_Form_Element_Text('sueldo');
        $sueldo->addValidator(new Zend_Validate_Alnum)
                ->setRequired(true);

        $fechaLimite = new Zend_Form_Element_Text('fechaLimite');
        $fechaLimite->setRequired()
                ->addFilter(new Zend_Filter_StringTrim())
                ->addValidator(new Zend_Validate_Date(array('format' => 'dd/MM/YYYY')));
        
        $arrayCategoria = Core_Utils::fetchPairs(Application_Entity_Subcategoria::getSubcategoriaByCategoria(10));
        $categoria = new Zend_Form_Element_Select('categoria', array('multiOptions' => array('' => '--Seleccionar--') + $arrayCategoria));
        
        $this->addElement($puesto)
                ->addElement($sueldo)
                ->addElement($categoria)
                ->addElement($funcion)
                ->addElement($fechaLimite);
        $this->formatDecoratorCustom();
    }

    

}
