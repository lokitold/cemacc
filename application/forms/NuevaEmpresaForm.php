<?php
class Application_Form_NuevaEmpresaForm extends Core_Form {

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
        
        $nombreVentas = new Zend_Form_Element_Text('nombreVentas');
        $nombreVentas->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El nombre ingresado no es válido')));
        
        $apellidoVentas = new Zend_Form_Element_Text('apellidoVentas');
        $apellidoVentas->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El nombre ingresado no es válido')));
        
        $nombreLogistica = new Zend_Form_Element_Text('nombreLogistica');
        $nombreLogistica->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El nombre ingresado no es válido')));
        
        $apellidoLogistica = new Zend_Form_Element_Text('apellidoLogistica');
        $apellidoLogistica->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El nombre ingresado no es válido')));
        
        $nombreRecursosHumanos = new Zend_Form_Element_Text('nombreRecursosHumanos');
        $nombreRecursosHumanos->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El nombre ingresado no es válido')));
        
        $arrayCategoria = Core_Utils::fetchPairs(Application_Entity_Categoria::getAllCategoria());
        $categoria = new Zend_Form_Element_Select('categoria', array('multiOptions' => array('' => '--Seleccionar--') + $arrayCategoria));
        $categoria->setRequired();
        
        $arrayPais = Core_Utils::fetchPairs(Application_Entity_Pais::getAllPais());
        $pais = new Zend_Form_Element_Select('pais', array('multiOptions' => array('' => '--Seleccionar--') + $arrayPais));
        $pais->setRequired();
        
        $apellidoRecursosHumanos = new Zend_Form_Element_Text('apellidoRecursosHumanos');
        $apellidoRecursosHumanos->addFilter('StringTrim')
                ->setAttribs(array('class' => 'input-sm'))
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El nombre ingresado no es válido')));
        
        $correoVentas = new Zend_Form_Element_Text('correoVentas');
        $correoVentas->addFilter(new Zend_Filter_HtmlEntities())
                ->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator(new Zend_Validate_EmailAddress())
                ->setAttribs(array('class' => 'input-sm'))
                ->addValidator('stringLength', true, array(1, 100));
        
        $correoLogistica = new Zend_Form_Element_Text('correoLogistica');
        $correoLogistica->addFilter(new Zend_Filter_HtmlEntities())
                ->addFilter('StringTrim')
                ->addValidator(new Zend_Validate_EmailAddress())
                ->setAttribs(array('class' => 'input-sm'))
                ->addValidator('stringLength', true, array(1, 100));
        
        $correoRecursosHumanos = new Zend_Form_Element_Text('correoRecursosHumanos');
        $correoRecursosHumanos->addFilter(new Zend_Filter_HtmlEntities())
                ->addFilter('StringTrim')
                ->addValidator(new Zend_Validate_EmailAddress())
                ->setAttribs(array('class' => 'input-sm'))
                ->addValidator('stringLength', true, array(1, 100));
        
        $this->addElement($nombreComercial)
                ->addElement($razonSocial)
                ->addElement($numeroRuc)
                ->addElement($direccion)
                ->addElement($pais)
                ->addElement($nombreVentas)
                ->addElement($apellidoVentas)
                ->addElement($nombreLogistica)
                ->addElement($apellidoLogistica)
                ->addElement($categoria)
                ->addElement($nombreRecursosHumanos)
                ->addElement($apellidoRecursosHumanos)
                ->addElement($correoVentas)
                ->addElement($correoLogistica)
                ->addElement($correoRecursosHumanos);

        $this->formatDecoratorCustom();
    }

    public function isValid($params) {
        return parent::isValid($params);
    }
}

