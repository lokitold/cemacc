<?php

class Administracion_IndexController extends Core_Controller_Admin
{
    public function init() {
        parent::init();
    }
    public function indexAction()
    {
        $this->view->headTitle('Bienvenidos');
    }
}

