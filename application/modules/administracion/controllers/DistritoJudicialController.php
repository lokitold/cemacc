<?php

class Administracion_DistritoJudicialController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->listAll = Application_Entity_DistritoJudicial::getAll();
    }

    public function nuevoAction() {
        $form = new Application_Form_NuevoDistritoJudicial();
        $params = $this->_getAllParams();
        if($this->getRequest()->isPost()){
            if($form->isValid($params)){
                $objectDsitritoJudicial = new Application_Entity_DistritoJudicial();
                $properties['_nombre'] = $params['nombre'];
                $properties['_estado'] = $params['estado'];
                $objectDsitritoJudicial->setProperties($properties);
                if($objectDsitritoJudicial->insert()!==False){
                    $this->getMessenger()->success('El Distrito Judicial se registro correctamente');
                }else{
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/distrito-judicial');
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        
    }

    public function activarAction() {
        
    }


}
