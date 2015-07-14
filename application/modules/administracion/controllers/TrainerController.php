<?php

class Administracion_TrainerController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headTitle('Trainer');
        $this->view->trainer = Application_Entity_Trainer::getAllTrainer();
    }

    public function nuevoAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-trainer-nuevo.js');
        $this->view->headTitle('Nuevo Trainer');
        $form = new Application_Form_NuevoTrainerForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {

            if ($form->isValid($params)) {
                $trainer = new Application_Entity_Trainer();
                $properties['_nombres'] = $form->getValue('nombres');
                $properties['_apellidos'] = $form->getValue('apellidos');
                $properties['_descripcion'] = $params['txtDescripcion'];

                //imagenes
                $file = $form->getValue('file');

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
                    $this->_redirect(BASE_URL . '/administracion/trainer');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                    $this->_redirect(BASE_URL . '/administracion/trainer');
                }
            }
        }

        $this->view->form = $form;
    }

    public function editarAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-trainer-editar.js');
        $this->view->headTitle('Editar Trainer');

        $form = new Application_Form_EditarTrainerForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {

            if ($form->isValid($params)) {
                $trainer = new Application_Entity_Trainer();
                $properties['_id'] = $form->getValue('trainer');
                $properties['_nombres'] = $form->getValue('nombres');
                $properties['_apellidos'] = $form->getValue('apellidos');
                $properties['_descripcion'] = $params['txtDescripcion'];

                //imagenes
                $file = $form->getValue('file');

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
                if ($trainer->update()) {
                    $this->getMessenger()->success('Trainer actualizado correctamente');
                    $this->_redirect(BASE_URL . '/administracion/trainer');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                    $this->_redirect(BASE_URL . '/administracion/trainer');
                }
            }
        }

        $trainer = new Application_Entity_Trainer();
        $data = $trainer->identify((int) $params['id']);
        $form->getElement('nombres')->setValue($data['trainer_nombres']);
        $form->getElement('apellidos')->setValue($data['trainer_apellidos']);
        $form->getElement('trainer')->setValue($data['trainer_id']);
        $this->view->trainer = $data;
        $this->view->form = $form;
    }

    public function activarAction() {
        $trainer = new Application_Entity_Trainer();
        $id = (int) $this->_getParam('id', 0);
        $estado = (int) $this->_getParam('flag', 0);

        if ($trainer->activar($id, $estado) !== false) {
            $this->getMessenger()->success('El Trainer ha sido activado/desactivado');
        } else {
            $this->getMessenger()->error('Hubo un Problema al realizar esta acción, por favor póngase en contacto con el administrador');
        }
        $this->_redirect('/administracion/trainer');
    }

}
