<?php

class Application_Form_NuevaAdquisicionLogisticaForm extends Core_Form {

    function init() {
        parent::init();
        $this->setMethod('Post');

        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->addFilter('StringTrim')
                ->setRequired(true);

        $descripcion = new Zend_Form_Element_Textarea('descripcion');
        $descripcion->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('rows', '3')
                ->setRequired(true);

        $precio = new Zend_Form_Element_Text('precio');
        $precio->addValidator(new Zend_Validate_Alnum);


        $cantidad = new Zend_Form_Element_Text('cantidad');
        $cantidad->addValidator(new Zend_Validate_Alnum)
                ->setRequired(true);

        $fechaLimite = new Zend_Form_Element_Text('fechaLimite');
        $fechaLimite->setRequired()
                ->addFilter(new Zend_Filter_StringTrim())
                ->addValidator(new Zend_Validate_Date(array('format' => 'dd/MM/YYYY')));

        $arrayCategoria = Core_Utils::fetchPairs(Application_Entity_Categoria::getAllCategoriaByTipo(1));
        $categoria = new Zend_Form_Element_Select('categoria', array('multiOptions' => array('' => '--Seleccionar--') + $arrayCategoria));

        $this->addElement($nombre)
                ->addElement($precio)
                ->addElement($cantidad)
                ->addElement($categoria)
                ->addElement($descripcion)
                ->addElement($fechaLimite);
        $this->formatDecoratorCustom();
    }

}
