<?php

class Administracion_SedeController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->sedes = Application_Entity_Sede::getAllSedes();
    }

    public function nuevoAction() {
        $form = new Application_Form_NuevaSedeForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {

                $sede = new Application_Entity_Sede();
                $properties['_nombre'] = $form->getValue('nombre');
                $properties['_especialidad'] = $form->getValue('especialidad');
                $properties['_direccion'] = $form->getValue('direccion');
                $sede->setProperties($properties);
                if ($sede->insert() !== false) {
                    $this->getMessenger()->success('La sede registró correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/sede');
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $form = new Application_Form_NuevaSedeForm();
        $params = $this->_getAllParams();
        $sede = new Application_Entity_Sede();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $properties['_id'] = $form->getValue('sede_id');
                $properties['_nombre'] = $form->getValue('nombre');
                $properties['_especialidad'] = $form->getValue('especialidad');
                $properties['_direccion'] = $form->getValue('direccion');
                $sede->setProperties($properties);
                if ($sede->update() !== false) {
                    $this->getMessenger()->success('La sede fue actualizada correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un al editar datos, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/sede');
            }
        }
        $dataSede = $sede->identify((int) $params['id']);
        if (empty($dataSede)) {
            $this->getMessenger()->error('No se encontró información sobre la sede seleccionada');
            $this->_redirect('/administracion/sede');
        }
        $form->getElement('sede_id')->setValue($sede->getPropertie('_id'));
        $form->getElement('nombre')->setValue($sede->getPropertie('_nombre'));
        $form->getElement('especialidad')->setValue($sede->getPropertie('_especialidad'));
        $form->getElement('direccion')->setValue($sede->getPropertie('_direccion'));
        $this->view->form = $form;
    }
    
    public function activarAction() {
        $params = $this->_getAllParams();
        if (Application_Entity_Sede::activar((int) $params['id'], (int) $params['flag'])) {
            $this->getMessenger()->success('Sede activada/desactivada');
            $this->_redirect('/administracion/sede');
        } else {
            $this->getMessenger()->error('La sede no existe');
            $this->_redirect('/administracion/sede');
        }
    }


}
