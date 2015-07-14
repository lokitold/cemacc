<?php

class Application_Form_EditarUsuarioForm extends Core_Form {

    function init() {
        parent::init();
        $this->setMethod('Post');

        $user = new Zend_Form_Element_Hidden('usuario_id');
        $user->addValidator(new Zend_Validate_Digits())
                ->setRequired(true);

        $implicado = new Zend_Form_Element_Hidden('implicado_id');
        $implicado->addValidator(new Zend_Validate_Digits())
                ->setRequired(true);

        $usuario = new Zend_Form_Element_Text('usuario');
        $usuario->addFilter(new Zend_Filter_StripTags())
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100));

        $arrayTipoDocumento = Core_Utils::fetchPairs(
                        Application_Entity_Usuario::getTiposDocumentoPersonaNatural()
        );
        $tipoDocumento = new Zend_Form_Element_Select('tipoDocumento', array('multiOptions' => array('' => '--Seleccionar--') + $arrayTipoDocumento));
        $tipoDocumento->setRequired(true);

        $nroDocumento = new Zend_Form_Element_Text('nroDocumento');
        $nroDocumento->addFilter(new Zend_Filter_StripTags())
                ->addFilter('StringTrim')
                ->setRequired(true);

        $nombres = new Zend_Form_Element_Text('nombres');
        $nombres->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El nombre ingresado no es válido')));

        $apellidoPaterno = new Zend_Form_Element_Text('apellidoPaterno');
        $apellidoPaterno->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator('stringLength', true, array(0, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El apellido ingresado no es válido')));

        $apellidoMaterno = new Zend_Form_Element_Text('apellidoMaterno');
        $apellidoMaterno->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator('stringLength', true, array(0, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'El apellido ingresado no es válido')));

        $telefono = new Zend_Form_Element_Text('telefono');
        $telefono->addValidator(new Zend_Validate_Alnum)
                ->addValidator(new Zend_Validate_StringLength(array('max' => '11', 'min' => '7')));

        $celular = new Zend_Form_Element_Text('celular');
        $celular->addValidator(new Zend_Validate_Alnum)
                ->addValidator(new Zend_Validate_StringLength(array('max' => '11', 'min' => '7')));

        $nroColegiatura = new Zend_Form_Element_Text('nroColegiatura');
        $nroColegiatura->addValidator(new Zend_Validate_Alnum)
                ->addValidator(new Zend_Validate_StringLength(array('max' => '11', 'min' => '7')));

        $email = new Zend_Form_Element_Text('email');
        $email->addFilter(new Zend_Filter_StripTags())
                ->addFilter('StringTrim')
                ->addValidator(new Zend_Validate_EmailAddress())
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100));

        $direccion = new Zend_Form_Element_Text('direccion');
        $direccion->addFilter('StringTrim')
                ->addValidator('stringLength', true, array(0, 200))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-Z0-9áÁéÉíÍóÓúÚñÑü&#º.,&\'\"\- )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'La dirección ingresada no es válida')));

        $arrayRoles = Core_Utils::fetchPairs(Application_Entity_Role::getAllRolesActivos());
        $rol = new Zend_Form_Element_Select('rol', array('multiOptions' => array('' => '--Seleccionar--') + $arrayRoles));

        $this->addElement($tipoDocumento)
                ->addElement($user)
                ->addElement($implicado)
                ->addElement($usuario)
                ->addElement($nroDocumento)
                ->addElement($nombres)
                ->addElement($apellidoPaterno)
                ->addElement($apellidoMaterno)
                ->addElement($email)
                ->addElement($telefono)
                ->addElement($celular)
                ->addElement($direccion)
                ->addElement($rol)
                ->addElement($nroColegiatura);
        $this->formatDecoratorCustom();
    }

    public function isValid($params, $idCliente = '') {
        if ($idCliente == '') {
            if ($params['tipoDocumento'] == Application_Entity_Usuario::TIPO_DOCUMENTO_DNI_ID) {
                $this->getElement('nroDocumento')->addValidator('stringLength', true, array(8, 8));
                $this->getElement('nroDocumento')->addValidator('Digits', true);
            }
            if ($params['tipoDocumento'] == Application_Entity_Usuario::TIPO_DOCUMENTO_CE_ID) {
                $this->getElement('nroDocumento')->addValidator('stringLength', true, array(9, 11));
                $this->getElement('nroDocumento')->addValidator(new Zend_Validate_Alnum(), true);
                $this->getElement('nroDocumento')->addFilter(new Zend_Filter_StringToUpper, true);
            }
        }
        return parent::isValid($params);
    }

}
