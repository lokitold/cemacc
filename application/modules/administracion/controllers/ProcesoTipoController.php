<?php

class Administracion_ProcesoTipoController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->listAll = Application_Entity_ProcesoTipo::getAll();
    }

    public function nuevoAction() {
        $form = new Application_Form_NuevoProcesoTipoForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $tipoProceso = new Application_Entity_ProcesoTipo();
                $properties['_nombre'] = $form->getValue('nombre');
                $properties['_estado'] = $form->getValue('estado');
                $tipoProceso->setProperties($properties);
                if ($tipoProceso->insert() !== false) {
                    $this->getMessenger()->success('El tipo de proceso se registro correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/proceso-tipo');
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $form = new Application_Form_EditarProcesoTipoForm();
        $params = $this->_getAllParams();
        $tipoProceso = new Application_Entity_ProcesoTipo();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $properties['_id'] = $form->getValue('id');
                $properties['_nombre'] = $form->getValue('nombre');
                $properties['_estado'] = $form->getValue('estado');
                $tipoProceso->setProperties($properties);
                if ($tipoProceso->update() !== false) {
                    $this->getMessenger()->success('El tipo de proceso se actualizó correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un al editar datos, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/proceso-tipo');
            }
        } else {
            $dataProceso = $tipoProceso->identify((int) $params['id']);
            if (empty($dataProceso)) {
                $this->getMessenger()->error('No se encontró información sobre el tipo de proceso');
                $this->_redirect('/administracion/proceso-tipo');
            }
            $form->getElement('id')->setValue($tipoProceso->getPropertie('_id'));
            $form->getElement('nombre')->setValue($tipoProceso->getPropertie('_nombre'));
            $form->getElement('estado')->setValue($tipoProceso->getPropertie('_estado'));
        }
        $this->view->form = $form;
    }

    public function activarAction() {
        $tipoProceso = new Application_Entity_ProcesoTipo();
        $properties['_id'] = (int)$this->_getParam('id',0);
        $properties['_estado'] = (int)$this->_getParam('flag',0);
        $tipoProceso->setProperties($properties);
        if ($tipoProceso->activar() !== false) {
            $this->getMessenger()->success('El tipo de proceso ha sido activado/desactivado');
        } else {
            $this->getMessenger()->error('Hubo un Problema al realizar esta acción, por favor póngase en contacto con el administrador');
        }
        $this->_redirect('/administracion/proceso-tipo');
    }

}
