<?php

class Application_Form_NuevaPublicacionVentasForm extends Core_Form {

    function init() {
        parent::init();
        $this->setMethod('Post');

        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->addFilter('StringTrim')
                ->setRequired(true);
        
        $descripcion = new Zend_Form_Element_Textarea('descripcion');
        $descripcion->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('rows', '4')
                ->setRequired(true);
        
        $precio = new Zend_Form_Element_Text('precio');
        $precio->addValidator(new Zend_Validate_Alnum)
                ->setRequired(true);
        
        $arrayCategoria = Core_Utils::fetchPairs(Application_Entity_Categoria::getAllCategoriaVentas());
        $categoria = new Zend_Form_Element_Select('categoria', array('multiOptions' => array('' => '--Seleccionar--') + $arrayCategoria));
        $categoria->setRequired();
        
        $cantidad = new Zend_Form_Element_Text('cantidad');
        $cantidad->addValidator(new Zend_Validate_Alnum)
                ->setRequired(true);
        
        $fechaInicio = new Zend_Form_Element_Text('fechaInicio');
        $fechaInicio->setRequired()
                ->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('class', 'fecha')
                ->setAttrib('disabled', 'disabled')
                ->addValidator(new Zend_Validate_Date(array('format' => 'dd/MM/YYYY')));
        
        $fechaFin = new Zend_Form_Element_Text('fechaFin');
        $fechaFin->setRequired()
                ->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('class', 'fecha')
                ->setAttrib('disabled', 'disabled')
                ->addValidator(new Zend_Validate_Date(array('format' => 'dd/MM/YYYY')));
        
        $file = new Zend_Form_Element_File('file');
        $file->setDestination(APPLICATION_PATH . '/../public/dinamic/ventas/')
                ->addValidator('IsImage', true)
                ->setRequired()
                ->addValidator('Size', true, 1024000)
                ->setAttrib('disabled', 'disabled')
                ->setValueDisabled(true);
        
        $this->addElement($nombre)
                ->addElement($precio)
                ->addElement($cantidad)
                ->addElement($descripcion)
                ->addElement($file)
                ->addElement($fechaInicio)
                ->addElement($categoria)
                ->addElement($fechaFin);
        $this->formatDecoratorCustom();
    }

    public function isValid($params) {
         
        return parent::isValid($params);
    }

}
