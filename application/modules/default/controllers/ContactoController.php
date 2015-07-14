<?php

class Default_ContactoController extends Core_Controller_Default
{
    public function init() {
        parent::init();
    }
    public function indexAction()
    {
        $this->view->headTitle('Contacto');
        $this->view->headTitle($this->view->title, 'APPEND');
    }
    
    
}

