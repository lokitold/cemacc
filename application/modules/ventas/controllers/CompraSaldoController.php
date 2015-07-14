<?php

class Ventas_CompraSaldoController extends Core_Controller_Ventas {

    public function init() {
        parent::init();
    }
    
    public function indexAction()
    {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/ventas-compra-saldo.js');
        $this->view->title = "Comprar Saldo";
        $this->view->headTitle($this->view->title, 'APPEND');
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
                $compraSaldo = new Application_Entity_CompraSaldo();
                $properties['_empresa'] = $this->_identity->empresa_id;
                $properties['_paquete'] = $params['idPaquete'];
                $compraSaldo->setProperties($properties);
                if ($compraSaldo->insert()) {
                    $this->getMessenger()->success('Gracias por realizar su compra');
                } else {
                    $this->getMessenger()->error('Hubo un Problema al mommento de Registrar la Compra');
                }
                $this->_redirect(BASE_URL.'/ventas');
        }
        $this->view->paquete = Application_Entity_Paquete::getAllPaquete();
    }

    public function detalleAction()
    {
        $this->view->title = "Detalle Publicación";
        $this->view->headTitle($this->view->title, 'APPEND');
        $publicacion = new Application_Entity_Publicacion();
        $this->view->publicacion = $publicacion->identify((int) $this->_getParam('id'));
    }

    public function ajaxGetSubcategoriaByCategoriaAction() {
        $this->_helper->json(
                Application_Entity_Subcategoria::getSubcategoriaByCategoria((int) $this->_getParam('id')));
    }

}
