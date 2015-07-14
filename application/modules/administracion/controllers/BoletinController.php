<?php

class Administracion_BoletinController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headTitle('Boletin');
        $this->view->boletin = Application_Entity_Boletin::getAllBoletin();
    }

    public function nuevoAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-boletin-nuevo.js');
        $this->view->headTitle('Nuevo Boletin');
        $form = new Application_Form_NuevoBoletinForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {

            if ($form->isValid($params)) {
                $boletin = new Application_Entity_Boletin();
                $properties['_fecha'] = $form->getValue('fecha');




                $adapter = new Zend_File_Transfer_Adapter_Http();
                $adapter->setDestination(APPLICATION_PATH . '/../public/dinamic/boletin/');
                $files = $adapter->getFileInfo();
                //var_dump($files); exit;
                if (isset($files)) {
                    foreach ($files as $fieldname => $fileinfo) {

                        if (($adapter->isUploaded($fileinfo['name'])) && ($adapter->isValid($fileinfo['name']))) {
                            $adapter->receive($fileinfo['name']);
                            if ($fileinfo['type'] == "image/jpeg") {
                                 $properties['_portada'] = $fileinfo['name'];
                            }else{
                                $properties['_url'] = $fileinfo['name'];
                            }
                        }
                    }
                }
                /* var_dump($files);
                  exit;
                  //pdf
                  $file = $form->getValue('file');

                  if (isset($file)) {
                  $nImg = time() . rand(1, 100);
                  $ext = '.' . pathinfo($file, PATHINFO_EXTENSION);
                  $file = 'file-' . $nImg . $ext;
                  $adapter = $form->getElement('file')->getTransferAdapter();
                  $adapter->addFilter('Rename', array(
                  'target' => APPLICATION_PATH . '/../public/dinamic/boletin/' . $file,
                  'overwrite' => true
                  ));
                  if ($adapter->receive())
                  $properties['_url'] = $file;
                  }

                  //portada
                  $portada = $form->getValue('portada');

                  if (isset($portada)) {
                  $nImg = time() . rand(1, 100);
                  $ext = '.' . pathinfo($portada, PATHINFO_EXTENSION);
                  $portada = 'file-' . $nImg . $ext;
                  $adapter = $form->getElement('file')->getTransferAdapter();
                  $adapter->addFilter('Rename', array(
                  'target' => APPLICATION_PATH . '/../public/dinamic/boletin/' . $portada,
                  'overwrite' => true
                  ));
                  if ($adapter->receive())
                  $properties['_portada'] = $portada;
                  } */

                $boletin->setProperties($properties);
                if ($boletin->insert()) {
                    $this->getMessenger()->success('Boletin registrado correctamente');
                    $this->_redirect(BASE_URL . '/administracion/boletin');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                    $this->_redirect(BASE_URL . '/administracion/boletin');
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

    public function eliminarAction() {
        $params = $this->_getAllParams();
        if (Application_Entity_Boletin::delete((int) $params['id'])) {
            $this->getMessenger()->success('El Boletín fue eliminado');
            $this->_redirect('/administracion/boletin');
        } else {
            $this->getMessenger()->error('Hubo un Problema al eliminar el Boletín, Por favor ponganse en contacto con el administrador');
            $this->_redirect('/administracion/boletin');
        }
    }

}
