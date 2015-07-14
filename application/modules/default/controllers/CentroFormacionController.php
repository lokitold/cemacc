<?php

class Default_CentroFormacionController extends Core_Controller_Default {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->title = "Centro de Formación";
        $this->view->headTitle($this->view->title, 'APPEND');
        $this->view->evento = Application_Entity_Capacitacion::getAllCapacitacion();
    }

    public function capacitacionAction() {
        $this->view->title = "Información de la Capacitación";
        $this->view->headTitle($this->view->title, 'APPEND');
        $id = $this->_getParam('taller');
        if (!isset($id)) {
            $this->_redirect(BASE_URL . '/centro-formacion');
        }

        $capacitacion = new Application_Entity_Capacitacion();
        $data = $capacitacion->identify($id);

        $this->view->capacitacion = $data;
        $this->view->evento = Application_Entity_Capacitacion::getAllCapacitacion();
    }

}
