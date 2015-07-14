<?php

class Application_Form_EnviarEmailContrasenaForm extends Core_Form {

    function init() {
        parent::init();
        $this->setMethod('Post');

        $email = new Zend_Form_Element_Text('email');
        $email->addFilter(new Zend_Filter_HtmlEntities())
                ->addFilter('StringTrim')
                ->setAttrib('class','form-control')
                ->setAttrib('placeholder','Correo Electrónico')
                ->addValidator(new Zend_Validate_EmailAddress())
                ->setRequired(true)
                ->addValidator('stringLength', true, array(1, 100));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('');

        $this->addElement($email)
                ->addElement($submit);
        $this->formatDecoratorCustom();
    }
    
}
