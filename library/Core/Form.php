<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form
 *
 * @author Laptop
 */
class Core_Form extends Zend_Form {

    protected $_formcontrol = array(
        'Zend_Form_Element_Text',
        'Zend_Form_Element_Password',
        'Zend_Form_Element_Select',
        'Zend_Form_Element_Textarea',
    );
    
    function init() {
        parent::init();
    }

    function customDecoratorFile($file) {
        $this->setDecorators(array(array('ViewScript', array('viewScript' => $file))));
    }

    function formatDecoratorCustom() {
        $elementos = $this->getElements();
        foreach ($elementos as $elemento) {
            if (in_array($elemento->getType(), $this->_formcontrol))
                $elemento->setAttrib('class', $elemento->getAttrib ('class').' form-control');
            
            if($elemento->isRequired()){
                $elemento->setAttrib('required', 'required');
            }
            
            if (!$elemento instanceof Zend_Form_Element_File)
                $elemento->setDecorators(array(
                    'ViewHelper',
                    'Errors'
                ));
            else
                $elemento->setDecorators(array(
                    'File',
                    'Errors'
                ));
        }
    }

    function setCaptcha() {
        $captcha = new Zend_Form_Element_Captcha('captcha', array(
            'id' => 'captcha',
            'title' => '',
            'captcha' => array(
                'captcha' => 'Image',
                'required' => true,
                'font' => APPLICATION_PATH . "/forms/fonts/arial.ttf",
                'wordlen' => '4',
                'ImgAlign' => 'left',
                'imgdir' => APPLICATION_PATH . "/../public/captcha",
                'DotNoiseLevel' => '5',
                'timeout' => '3000000',
                'LineNoiseLevel' => '5',
                'fontsize' => '30',
                'gcFreq' => '10',
                'ImgAlt' => 'Código de Verificación',
                'imgurl' => BASE_URL . '/captcha'
            ),
                )
        );
        $captcha_value = $this->createElement('hidden', 'captcha_value');
        $this->addElement($captcha)->addElement($captcha_value);
        $this->getElement('captcha')->setAttribs(array('class' => 'rightimg'))
                ->removeDecorator('label');
    }

    function populate(array $values) {
        foreach ($values as $key => $value)
            $values[$key] = html_entity_decode ($value);
        parent::populate($values);
    }
}

?>
