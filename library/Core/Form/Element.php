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
class Core_Form_Element extends Zend_Form_Element {
    
    function setValue($value) {
        parent::setValue(html_entity_decode($value));
    }
}