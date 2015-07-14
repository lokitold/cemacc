<?php

class Administracion_ProcesoController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->listAll = Application_Entity_Proceso::getAll();
    }

    public function nuevoAction() {
        $form = new Application_Form_NuevoProcesoForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $proceso = new Application_Entity_Proceso();
                $properties['_nombre'] = $form->getValue('nombre');
                $properties['_estado'] = $form->getValue('estado');
                $properties['_tipoProceso'] = $form->getValue('tipoProceso');
                $proceso->setProperties($properties);
                if ($proceso->insert() !== false) {
                    $this->getMessenger()->success('El proceso se registro correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/proceso');
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $form = new Application_Form_EditarProcesoForm();
        $params = $this->_getAllParams();
        $proceso = new Application_Entity_Proceso();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $properties['_id'] = $form->getValue('id');
                $properties['_nombre'] = $form->getValue('nombre');
                $properties['_estado'] = $form->getValue('estado');
                $properties['_tipoProceso'] = $form->getValue('tipoProceso');
                $proceso->setProperties($properties);
                if ($proceso->update() !== false) {
                    $this->getMessenger()->success('El proceso se actualizó correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un al editar datos, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/proceso');
            }
        } else {
            $dataProceso = $proceso->identify((int) $params['id']);
            if (empty($dataProceso)) {
                $this->getMessenger()->error('No se encontró información sobre el proceso');
                $this->_redirect('/administracion/proceso');
            }
            $form->getElement('id')->setValue($proceso->getPropertie('_id'));
            $form->getElement('nombre')->setValue($proceso->getPropertie('_nombre'));
            $form->getElement('estado')->setValue($proceso->getPropertie('_estado'));
            $form->getElement('tipoProceso')->setValue($proceso->getPropertie('_tipoProceso'));
        }
        $this->view->form = $form;
    }

    public function activarAction() {
        $proceso = new Application_Entity_Proceso();
        $properties['_id'] = (int)$this->_getParam('id',0);
        $properties['_estado'] = (int)$this->_getParam('flag',0);
        $proceso->setProperties($properties);
        if ($proceso->activar() !== false) {
            $this->getMessenger()->success('El proceso ha sido activado/desactivado');
        } else {
            $this->getMessenger()->error('Hubo un Problema al realizar esta acción, por favor póngase en contacto con el administrador');
        }
        $this->_redirect('/administracion/proceso');
    }

}
