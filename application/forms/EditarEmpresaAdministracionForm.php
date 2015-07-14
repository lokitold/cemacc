<?php

class Application_Form_EditarEmpresaAdministracionForm extends Core_Form {

    function init() {
        parent::init();

        $idCategoria = $this->getAttrib('categoria');
        $dataDepartamento = $this->getAttrib('departamento');
        $dataProvincia = $this->getAttrib('provincia');

        $empresa = new Zend_Form_Element_Hidden('empresa');
        $empresa->addValidator(new Zend_Validate_Digits())
                ->setRequired(true);
        
        $ubicacion = new Zend_Form_Element_Hidden('ubicacion');
        $ubicacion->addValidator(new Zend_Validate_Digits())
                ->setRequired(true);

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

        $ubigeo = new Zend_Form_Element_Hidden('ubigeo');
        $ubigeo->addValidator(new Zend_Validate_Digits())
                ->setRequired(true);

        $direccion = new Zend_Form_Element_Textarea('direccion');
        $direccion->addFilter(new Zend_Filter_StringTrim())
                ->setAttrib('rows', '3');

        $arrayCategoria = Core_Utils::fetchPairs(Application_Entity_Categoria::getAllCategoria());
        $categoria = new Zend_Form_Element_Select('categoria', array('multiOptions' => array('' => '--Seleccionar--') + $arrayCategoria));

        $arraySubCategoria = Core_Utils::fetchPairs(Application_Entity_Subcategoria::getSubcategoriaByCategoria($idCategoria));
        $subcategoria = new Zend_Form_Element_Select('subcategoria', array('multiOptions' => array('' => '--Seleccionar--') + $arraySubCategoria));
        $subcategoria->setAttribs(array('class' => 'input-sm'))
                ->setRequired(true);

        $arrayPais = Core_Utils::fetchPairs(Application_Entity_Pais::getAllPais());
        $pais = new Zend_Form_Element_Select('pais', array('multiOptions' => array('' => '--Seleccionar--') + $arrayPais));
        $pais->setRequired();

        $getDepartamento = Application_Entity_Ubigeo::getAllDepartamento();
        foreach ($getDepartamento as $val) {
            $arrayDepartamento[$val['departamento']] = $val['departamento'];
        }
        $departamento = new Zend_Form_Element_Select('departamento', array('multiOptions' => array('' => '--Seleccionar--') + $arrayDepartamento));
        $departamento->setRequired()
                ->setAttribs(array('class' => 'input-sm'));


        $getProvincia = Application_Entity_Ubigeo::getProvinciaByDepartamento($dataDepartamento);
        foreach ($getProvincia as $val) {
            $arrayProvincia[$val['provincia']] = $val['provincia'];
        }
        $provincia = new Zend_Form_Element_Select('provincia', array('multiOptions' => array('' => '--Seleccionar--') + $arrayProvincia));
        $provincia->setRequired()
                ->setAttribs(array('class' => 'input-sm'));


        $getDistrito = Application_Entity_Ubigeo::getDistritoByProvincia($dataProvincia);
        foreach ($getDistrito as $val) {
            $arrayDistrito[$val['distrito']] = $val['distrito'];
        }
        $distrito = new Zend_Form_Element_Select('distrito', array('multiOptions' => array('' => '--Seleccionar--') + $arrayDistrito));
        $distrito->setRequired()
                ->setAttribs(array('class' => 'input-sm'));

        $this->addElement($nombreComercial)
                ->addElement($empresa)
                ->addElement($razonSocial)
                ->addElement($ubigeo)
                ->addElement($subcategoria)
                ->addElement($departamento)
                ->addElement($provincia)
                ->addElement($ubicacion)
                ->addElement($distrito)
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
