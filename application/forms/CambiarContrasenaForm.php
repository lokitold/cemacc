<?php

class Application_Form_CambiarContrasenaForm extends Core_Form {

    function init() {

        parent::init();

        $contrasena = new Zend_Form_Element_Password('contrasena');
        $contrasena->addFilter('StringTrim')->setAttribs(array('class' => ''))
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-Z0-9áÁéÉíÍóÓúÚñÑü&#º.,&\'\"\- )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'La contraseña ingresada no es válida')))
                ->addValidator(new Core_Validate_checkUsuarioPassword())
                ->setRequired(true);

        $contrasenaNueva = new Zend_Form_Element_Password('contrasenaNueva');
        $contrasenaNueva->addFilter('StringTrim')->setAttribs(array('class' => ''))
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator(new Zend_Validate_Identical())
                ->setRequired(true)
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-Z0-9áÁéÉíÍóÓúÚñÑü&#º.,&\'\"\- )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'La contraseña ingresada no es válida')));

        $contrasenaNueva2 = new Zend_Form_Element_Password('contrasenaNueva2');
        $contrasenaNueva2->addFilter('StringTrim')->setAttribs(array('class' => ''))
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-Z0-9áÁéÉíÍóÓúÚñÑü&#º.,&\'\"\- )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'La contraseña ingresada no es válida')));
        
        $usuario = new Zend_Form_Element_Hidden('usuario');
        $usuario->addValidator(new Zend_Validate_Digits())
                ->setRequired(true);

        $this->addElement($contrasena)
                ->addElement($usuario)
                ->addElement($contrasenaNueva)
                ->addElement($contrasenaNueva2);
        $this->formatDecoratorCustom();
    }

    function isValid($data) {
        $passwordConfirm = $this->getElement('contrasenaNueva');
        $validator = $passwordConfirm->getValidator('Identical')
                ->setToken($data['contrasenaNueva2']);
        return parent::isValid($data);
    }

}
