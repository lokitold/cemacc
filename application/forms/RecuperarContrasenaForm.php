<?php

class Application_Form_RecuperarContrasenaForm extends Core_Form {

    function init() {

        parent::init();

        $contraseñaNueva = new Zend_Form_Element_Password('password');
        $contraseñaNueva->addFilter('StringTrim')->setAttribs(array('class' => ''))
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-Z0-9áÁéÉíÍóÓúÚñÑü&#º.,&\'\"\- )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'La contraseña ingresada no es válida')));

        $contraseñaNueva2 = new Zend_Form_Element_Password('rpassword');
        $contraseñaNueva2->addFilter('StringTrim')->setAttribs(array('class' => ''))
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-Z0-9áÁéÉíÍóÓúÚñÑü&#º.,&\'\"\- )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'La contraseña ingresada no es válida')));

        $personalId = new Zend_Form_Element_Hidden('usuario');
        $hash = new Zend_Form_Element_Hidden('hash');

        $this->addElement($personalId)
                ->addElement($contraseñaNueva)
                ->addElement($hash)
                ->addElement($contraseñaNueva2);
        $this->formatDecoratorCustom();
    }
    function isValid($data) {
        parent::isValid($data);
        if($data['password']!=$data['rpassword']){
            $this->getElement('rpassword')->setErrorMessages(array('contrasena'=>'Las contraseñas no coinciden'));
            return false;
        }else{
            return true;
        }
        
        
    }

}