<?php

class Ventas_IndexController extends Core_Controller_Ventas
{
    public function init() {
        parent::init();
    }
    public function indexAction()
    {
        $this->view->headTitle('Bienvenidos');
      
    }
}

