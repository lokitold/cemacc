<?php

class Default_DirectorioController extends Core_Controller_Default {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->title = "Directorio Empresarial";
        $this->view->headTitle($this->view->title, 'APPEND');
        $this->view->categoria = Application_Entity_Categoria::getAllCategoria();
    }
    
    public function categoriaAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/default-directorio-categoria.js');
        $this->view->title = "Categoría";
        $this->view->headTitle($this->view->title, 'APPEND');
        $this->view->empresa = Application_Entity_Empresa::getEmpresaByCategoria((int) $this->_getParam('id'));
    }
    
     public function empresaAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/default-directorio-categoria.js');
        $id = $this->_getParam('id');
        $empresa = new Application_Entity_Empresa();
        $dataEmpresa = $empresa->identify($id);
        $this->view->title = $empresa->getPropertie('_nombreComercial');
        $this->view->headTitle($this->view->title, 'APPEND');
        $this->view->empresa = $dataEmpresa;
        
    }

}
