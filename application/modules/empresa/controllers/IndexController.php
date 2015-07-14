<?php

class Empresa_IndexController extends Core_Controller_Empresa
{
    public function init() {
        parent::init();
    }
    public function indexAction()
    {
        $this->view->headTitle('Bienvenidos');
      
    }
}

