<?php

class Administracion_AsesoriaController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headTitle('Asesoría');
        $this->view->asesoria = Application_Entity_Asesoria::getAllAsesoria();
    }

    public function nuevoAction() {
        //$this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-empresa-nuevo.js');
        $this->view->title = "Nueva Asesoría";
        $form = new Application_Form_NuevaAsesoriaForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $asesoria = new Application_Entity_Asesoria();
                $properties['_titulo'] = $form->getValue('titulo');
                $properties['_descripcion'] = $form->getValue('descripcion');
                $asesoria->setProperties($properties);

                if ($asesoria->insert()) {
                    $this->getMessenger()->success('La Asesoría se registró correctamente');
                    $this->_redirect(BASE_URL . '/administracion/asesoria');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                    $this->_redirect(BASE_URL . '/administracion/asesoria');
                }
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        //$this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-empresa-nuevo.js');
        $this->view->title = "Editar Asesoría";
        $form = new Application_Form_EditarAsesoriaForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $asesoria = new Application_Entity_Asesoria();
                $properties['_id'] = $form->getValue('asesoria');
                $properties['_titulo'] = $form->getValue('titulo');
                $properties['_descripcion'] = $form->getValue('descripcion');
                $asesoria->setProperties($properties);

                if ($asesoria->update()) {
                    $this->getMessenger()->success('La Asesoría se actualizó correctamente');
                    $this->_redirect(BASE_URL . '/administracion/asesoria');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en la actualización, Por favor ponganse en contacto con el administrador');
                    $this->_redirect(BASE_URL . '/administracion/asesoria');
                }
            }
        }

        $asesoria = new Application_Entity_Asesoria();
        $data = $asesoria->identify((int) $params['id']);

        $form->getElement('asesoria')->setValue($data['asesoria_id']);
        $form->getElement('titulo')->setValue($data['asesoria_titulo']);
        $form->getElement('descripcion')->setValue($data['asesoria_descripcion']);

        $this->view->form = $form;
    }

    public function activarAction() {
        $asesoria = new Application_Entity_Asesoria();
        $id = (int) $this->_getParam('id', 0);
        $estado = (int) $this->_getParam('flag', 0);

        if ($asesoria->activar($id, $estado) !== false) {
            $this->getMessenger()->success('La Asesoría ha sido activada/desactivada');
        } else {
            $this->getMessenger()->error('Hubo un Problema al realizar esta acción, por favor póngase en contacto con el administrador');
        }
        $this->_redirect('/administracion/asesoria');
    }

}
