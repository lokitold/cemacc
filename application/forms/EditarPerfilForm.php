<?php

class Application_Form_EditarPerfilForm extends Application_Form_NuevoUsuarioForm {

    function init() {
        parent::init();
        $this->setMethod('Post');
       
        $nombres = new Zend_Form_Element_Text('nombres');
        $nombres->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'Nombre ingresado no es válido')));

        $apellidos = new Zend_Form_Element_Text('apellidos');
        $apellidos->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator('stringLength', true, array(0, 100))
                ->addValidator('regex', true, array(
                    'pattern' => '/^[(a-zA-ZáÁéÉíÍóÓúÚñÑü )]+$/',
                    'messages' => array(
                        'regexNotMatch' => 'Apellido ingresado no es válido')));
        
        $email = new Zend_Form_Element_Text('email');
        $email->addFilter(new Zend_Filter_StripTags())
                ->addFilter('StringTrim')
                //->addValidator(new Application_Form_Validators_UniqueUsuarioEmail, true)
                ->addValidator(new Zend_Validate_EmailAddress())
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100));
        
        $telefono = new Zend_Form_Element_Text('telefono');
        $telefono->addValidator(new Zend_Validate_Alnum)
                ->addValidator(new Zend_Validate_StringLength(array('max' => '11', 'min' => '7')));

    }
}
