<?php

class Administracion_EspecialidadController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->listAll = Application_Entity_Especialidad::getAll();
    }

    public function nuevoAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-especialidad-nuevo.js');
        $form = new Application_Form_NuevaEspecialidadForm();
        $params = $this->_getAllParams();
        if($this->getRequest()->isPost()){
            if($form->isValid($params)){
                $objectEspecialidad = new Application_Entity_Especialidad();
                $properties['_nombre'] = $params['nombre'];
                $properties['_distritoJudicialId'] = $params['distrito'];
                $properties['_organoJurisdiccionalId'] = $params['organo'];
                $objectEspecialidad->setProperties($properties);
                if($objectEspecialidad->insert()!==False){
                    $this->getMessenger()->success('la especialidad  se registro correctamente');
                }else{
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/especialidad');
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $form = new Application_Form_EditarEspecialidadForm();
        $params = $this->_getAllParams();
        $objectEspecialidad = new Application_Entity_Especialidad();
        if($this->getRequest()->isPost()){
            if($form->isValid($params)){
                
                $properties['_id'] = $params['especialidad'];
                $properties['_nombre'] = $params['nombre'];
                $properties['_distritoJudicialId'] = $params['distrito'];
                $properties['_organoJurisdiccionalId'] = $params['organo'];
                $objectEspecialidad->setProperties($properties);
                if($objectEspecialidad->update()!==False){
                    $this->getMessenger()->success('la especialidad se actualizo correctamente');
                }else{
                    $this->getMessenger()->error('Hubo un Problema en la actualizacion, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/especialidad');
            }
        }
        $data=$objectEspecialidad->identify((int) $params['id']);
        if (empty($data)) {
                $this->getMessenger()->error('Especialidad no encontrada');
                $this->_redirect('/administracion/especialidad');
            }
            $form->getElement('especialidad')->setValue($data['especialidad_id']);
            $form->getElement('organo')->setValue($data['organo_jurisdiccional_id']);
            $form->getElement('nombre')->setValue($data['especialidad_nombre']);
            $form->getElement('distrito')->setValue($data['distrito_judicial_id']);
         
        
        
        $this->view->form = $form;
    }

    public function eliminarAction() {
        $params = $this->_getAllParams();
        if (Application_Entity_Especialidad::eliminar((int) $params['id'])) {
            $this->getMessenger()->success('Especialidad Eliminada');
            $this->_redirect('/administracion/especialidad');
        } else {
            $this->getMessenger()->error('La especialidad no existe ');
            $this->_redirect('/administracion/especialidad');
        }
    }
    
    
    public function activarAction() {
        $proceso = new Application_Entity_Especialidad();
        $properties['_id'] = (int)$this->_getParam('id',0);
        $properties['_flag'] = (int)$this->_getParam('flag',0);
        $proceso->setProperties($properties);
        if ($proceso->activar() !== false) {
            $this->getMessenger()->success('La Especialidad ha sido activado/desactivado');
        } else {
            $this->getMessenger()->error('Hubo un Problema al realizar esta acción, por favor póngase en contacto con el administrador');
        }
        $this->_redirect('/administracion/especialidad');
    }


}
