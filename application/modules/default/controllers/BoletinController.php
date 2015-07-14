<?php

class Default_BoletinController extends Core_Controller_Default {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->title = "Boletín Mensual";
        $this->view->headTitle($this->view->title, 'APPEND');
        $this->view->boletin = Application_Entity_Boletin::getAllBoletin();
    }

}
