<?php
class Application_Form_NuevaCapacitacionForm extends Core_Form {

    function init() {
        parent::init();
        
        $titulo = new Zend_Form_Element_Text('titulo');
        $titulo->addFilter('StringTrim')
                ->setRequired(true);
        
        $fecha= new Zend_Form_Element_Text('fecha');
        $fecha->setRequired()
                ->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('class', 'fecha')
                ->addValidator(new Zend_Validate_Date(array('format' => 'dd/MM/YYYY')));
        
        $file = new Zend_Form_Element_File('file');
        $file->setDestination(APPLICATION_PATH . '/../public/dinamic/capacitacion/')
                ->addValidator('IsImage', true)
                ->setRequired()
                ->addValidator('Size', true, 1024000)
                ->setValueDisabled(true);
        
        $asiste = new Zend_Form_Element_Textarea('asiste');
        $asiste->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('rows', '5')
                ->setRequired(true);
        
        $arrayTrainer = Core_Utils::fetchPairsTrainer(Application_Entity_Trainer::getActivos());
        $trainer = new Zend_Form_Element_Select('trainer', array('multiOptions' => array('' => '--Seleccionar--') + $arrayTrainer));
        
        $this->addElement($titulo)
                ->addElement($fecha)
                ->addElement($asiste)
                ->addElement($trainer)
                ->addElement($file);

        $this->formatDecoratorCustom();
    }

    public function isValid($params) {
        return parent::isValid($params);
    }
}

