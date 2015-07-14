<?php

class Ventas_PublicarController extends Core_Controller_Ventas {

    public function init() {
        parent::init();
    }
    
    public function indexAction()
    {
       
        $this->view->title = "Publicaciones";
        $this->view->headTitle($this->view->title, 'APPEND');
        $this->view->publicacion = Application_Entity_Publicacion::getPublicacionByEmpresa((int)$this->_identity->empresa_id);
    }

    public function nuevoAction() {
           if(empty($this->_saldo)){
            $this->getMessenger()->error('Debe tener Saldo Disponible para Publicar');
            $this->_redirect(BASE_URL.'/ventas/compra-saldo');
        }    
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/ventas-publicar-nuevo.js');
        $this->view->title = "Publicar";
        $this->view->headTitle($this->view->title, 'APPEND');
        $form = new Application_Form_NuevaPublicacionVentasForm();
        $params = $this->_getAllParams();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                
                $trainer = new Application_Entity_Trainer();
                $properties['_nombres'] = $form->getValue('nombres');
                $properties['_apellidos'] = $form->getValue('apellidos');
                $properties['_descripcion'] = $form->getValue('categoria');
                
                $file = $form->getValue('file');
                //imagen               
                if (isset($file)) {
                    $nImg = time() . rand(1, 100);
                    $ext = '.' . pathinfo($file, PATHINFO_EXTENSION);
                    $imagen = 'file-' . $nImg . $ext;
                    $adapter = $form->getElement('file')->getTransferAdapter();
                    $adapter->addFilter('Rename', array(
                        'target' => APPLICATION_PATH . '/../public/dinamic/trainer/' . $imagen,
                        'overwrite' => true
                    ));
                    if ($adapter->receive())
                        $properties['_foto'] = $imagen;
                }
                $trainer->setProperties($properties);
                if ($trainer->insert()) {
                    $this->getMessenger()->success('Trainer registrado correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un Problema al registrar el trainer, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect(BASE_URL.'/administracion/trainer');
            }
        }
//        var_dump($this->_identity->empresa_id);
//        exit();
        $this->view->form = $form;
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
