<?php

class RecursosHumanos_IndexController extends Core_Controller_RecursosHumanos
{
    public function init() {
        parent::init();
    }
    public function indexAction()
    {
        $this->view->headTitle('Bienvenidos');
    }
}

