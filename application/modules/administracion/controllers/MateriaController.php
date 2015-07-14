<?php

class Administracion_MateriaController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->listAll = Application_Entity_Materia::getAll();
    }

    public function nuevoAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-materia-nuevo.js');
        $form = new Application_Form_NuevaMateriaForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $proceso = new Application_Entity_Materia();
                $properties['_nombre'] = $form->getValue('nombre');
                $properties['_estado'] = $form->getValue('estado');
                $properties['_tipoProceso'] = $form->getValue('tipoProceso');
                $properties['_proceso'] = $form->getValue('proceso');
                $proceso->setProperties($properties);
                if ($proceso->insert() !== false) {
                    $this->getMessenger()->success('La materia se registro correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/materia');
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-materia-nuevo.js');
        $form = new Application_Form_EditarMateriaForm();
        $params = $this->_getAllParams();
        $proceso = new Application_Entity_Materia();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $properties['_id'] = $form->getValue('id');
                $properties['_nombre'] = $form->getValue('nombre');
                $properties['_estado'] = $form->getValue('estado');
                $properties['_tipoProceso'] = $form->getValue('tipoProceso');
                $properties['_proceso'] = $form->getValue('proceso');
                $proceso->setProperties($properties);
                if ($proceso->update() !== false) {
                    $this->getMessenger()->success('La materia se actualizó correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un al editar datos, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/materia');
            }
        } else {
            $dataMateria = $proceso->identify((int) $params['id']);
            if (empty($dataMateria)) {
                $this->getMessenger()->error('No se encontró información sobre el proceso');
                $this->_redirect('/administracion/materia');
            }
            $form->getElement('id')->setValue($proceso->getPropertie('_id'));
            $form->getElement('nombre')->setValue($proceso->getPropertie('_nombre'));
            $form->getElement('estado')->setValue($proceso->getPropertie('_estado'));
            $form->getElement('proceso')->setValue($proceso->getPropertie('_proceso'));
            $form->getElement('tipoProceso')->setValue($proceso->getPropertie('_tipoProceso'));
        }
        $this->view->form = $form;
    }

    public function activarAction() {
        $proceso = new Application_Entity_Materia();
        $properties['_id'] = (int)$this->_getParam('id',0);
        $properties['_estado'] = (int)$this->_getParam('flag',0);
        $proceso->setProperties($properties);
        if ($proceso->activar() !== false) {
            $this->getMessenger()->success('La Materia ha sido activado/desactivado');
        } else {
            $this->getMessenger()->error('Hubo un Problema al realizar esta acción, por favor póngase en contacto con el administrador');
        }
        $this->_redirect('/administracion/materia');
    }

}
