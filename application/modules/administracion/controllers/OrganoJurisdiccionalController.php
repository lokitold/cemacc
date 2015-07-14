<?php

class Administracion_OrganoJurisdiccionalController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->listAll = Application_Entity_OrganoJurisdiccional::getAll();
    }

    public function nuevoAction() {
        $form = new Application_Form_NuevoOrganoJurisdiccionalForm();
        $params = $this->_getAllParams();
        if($this->getRequest()->isPost()){
            if($form->isValid($params)){
                $objectJuzgado = new Application_Entity_OrganoJurisdiccional();
                $properties['_nombre'] = $params['nombre'];
                $properties['_distritoJudicialId'] = $params['distrito'];
                $objectJuzgado->setProperties($properties);
                if($objectJuzgado->insert()!==False){
                    $this->getMessenger()->success('El Organo Jurisdiccional se registro correctamente');
                }else{
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/organo-jurisdiccional');
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $form = new Application_Form_EditarOrganoJurisdiccionalForm();
        $params = $this->_getAllParams();
        $objectJuzgado = new Application_Entity_OrganoJurisdiccional();
        if($this->getRequest()->isPost()){
            if($form->isValid($params)){
                
                $properties['_id'] = $params['organoJurisdiccional'];
                $properties['_nombre'] = $params['nombre'];
                $properties['_distritoJudicialId'] = $params['distrito'];
                $objectJuzgado->setProperties($properties);
                if($objectJuzgado->update()!==False){
                    $this->getMessenger()->success('El Organo Jurisdiccional se actualizo correctamente');
                }else{
                    $this->getMessenger()->error('Hubo un Problema en la actualizacion, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/organo-jurisdiccional');
            }
        }
        $data=$objectJuzgado->identify((int) $params['id']);
        if (empty($data)) {
                $this->getMessenger()->error('Organo jurisdiccional no encontrado');
                $this->_redirect('/administracion/organo-jurisdiccional');
            }
            $form->getElement('organoJurisdiccional')->setValue($data['organo_jurisdiccional_id']);
            $form->getElement('nombre')->setValue($data['organo_jurisdiccional_nombre']);
            $form->getElement('distrito')->setValue($data['distrito_judicial_id']);
         
        
        
        $this->view->form = $form;
    }

    public function eliminarAction() {

        $params = $this->_getAllParams();
        if (Application_Entity_OrganoJurisdiccional::eliminar((int) $params['id'])) {
            $this->getMessenger()->success('Organo jurisdiccional Eliminado');
            $this->_redirect('/administracion/organo-jurisdiccional');
        } else {
            $this->getMessenger()->error('El organo jurisdiccional no existe ');
            $this->_redirect('/administracion/organo-jurisdiccional');
        }

    }
    
       public function activarAction() {
        $organo = new Application_Entity_OrganoJurisdiccional();
        $properties['_id'] = (int)$this->_getParam('id',0);
        $properties['_flag'] = (int)$this->_getParam('flag',0);
        $organo->setProperties($properties);

        if ($organo->activar() !== false) {
            $this->getMessenger()->success('El Organo Jurisdiccional  ha sido activado/desactivado');
        } else {
            $this->getMessenger()->error('Hubo un Problema al realizar esta acción, por favor póngase en contacto con el administrador');
        }
        $this->_redirect('/administracion/organo-jurisdiccional');
    }


}
