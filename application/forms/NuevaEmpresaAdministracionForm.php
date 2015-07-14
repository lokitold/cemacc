<?php
class Application_Form_NuevaEmpresaAdministracionForm extends Core_Form {

    function init() {
        parent::init();
        
        $nombreComercial = new Zend_Form_Element_Text('nombreComercial');
        $nombreComercial->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->setRequired(true);
        
        $razonSocial = new Zend_Form_Element_Text('razonSocial');
        $razonSocial->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->setRequired(true);
        
        $numeroRuc = new Zend_Form_Element_Text('numeroRuc');
        $numeroRuc->addFilter(new Zend_Filter_HtmlEntities())
                ->setRequired(true)
                ->setAttribs(array('class' => 'input-sm'))
                ->addFilter('StringTrim');
       
        $direccion = new Zend_Form_Element_Textarea('direccion');
        $direccion->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('rows', '3');
        
        $arrayCategoria = Core_Utils::fetchPairs(Application_Entity_Categoria::getAllCategoria());
        $categoria = new Zend_Form_Element_Select('categoria', array('multiOptions' => array('' => '--Seleccionar--') + $arrayCategoria));
        
        $arrayPais = Core_Utils::fetchPairs(Application_Entity_Pais::getAllPais());
        $pais = new Zend_Form_Element_Select('pais', array('multiOptions' => array('' => '--Seleccionar--') + $arrayPais));
        $pais->setRequired();
        
        $this->addElement($nombreComercial)
                ->addElement($razonSocial)
                ->addElement($numeroRuc)
                ->addElement($direccion)
                ->addElement($categoria)
                ->addElement($pais);

        $this->formatDecoratorCustom();
    }

    public function isValid($params) {
        return parent::isValid($params);
    }
}

