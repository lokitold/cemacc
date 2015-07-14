<?php

class Default_IndexController extends Core_Controller_Default
{
    public function init() {
        parent::init();
    }
    public function indexAction()
    {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/default-index-index.js');
        $this->view->headTitle('Bienvenidos');
        $this->view->publicacion1 = Application_Entity_Publicacion::getPublicacionHome(1);
        $this->view->publicacion2 = Application_Entity_Publicacion::getPublicacionHome(2);
        $this->view->publicacion3 = Application_Entity_Publicacion::getPublicacionHome(3);
        $this->view->publicacion4 = Application_Entity_Publicacion::getPublicacionHome(4);
        $this->view->publicacion5 = Application_Entity_Publicacion::getPublicacionHome(5);
        $this->view->publicacion6 = Application_Entity_Publicacion::getPublicacionHome(6);
        $this->view->publicacion7 = Application_Entity_Publicacion::getPublicacionHome(7);
        $this->view->publicacion8 = Application_Entity_Publicacion::getPublicacionHome(8);
        $this->view->publicacion9 = Application_Entity_Publicacion::getPublicacionHome(9);
        $this->view->logos = Application_Entity_Empresa::getLogos();
        $this->view->capacitacion = Application_Entity_Capacitacion::getAllCapacitacion();
        $this->view->asesoria = Application_Entity_Asesoria::getAllAsesoria();
        //var_dump($this->view->publicacion1); exit();
    }
    
}

