<?php

class Logistica_IndexController extends Core_Controller_Logistica
{
    public function init() {
        parent::init();
    }
    public function indexAction()
    {
        $this->view->headTitle('Bienvenidos');
    }
}

