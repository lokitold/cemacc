<?php

class Default_CentroEmpresarialController extends Core_Controller_Default {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->title = "Centro Empresarial";
        $this->view->headTitle($this->view->title, 'APPEND');
    }

}
