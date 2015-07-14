<?php

class Administracion_CapacitacionController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headTitle('Capacitación');
        $this->view->capacitacion = Application_Entity_Capacitacion::getAllCapacitacion();
    }

    public function nuevoAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-capacitacion-nuevo.js');
        $this->view->title = "Nueva Capacitación";
        $form = new Application_Form_NuevaCapacitacionForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $capacitacion = new Application_Entity_Capacitacion();
                $properties['_titulo'] = $form->getValue('titulo');
                $properties['_fecha'] = $form->getValue('fecha');
                $properties['_asiste'] = $form->getValue('asiste');
                $properties['_trainer'] = $form->getValue('trainer');
                $properties['_presentacion'] = $params['txtPresentacion'];
                $properties['_beneficios'] = $params['txtBeneficios'];
                $properties['_contenido'] = $params['txtContenido'];
                $properties['_info'] = $params['txtInfo'];

                $file = $form->getValue('file');

                if (isset($file)) {
                    $nImg = time() . rand(1, 100);
                    $ext = '.' . pathinfo($file, PATHINFO_EXTENSION);
                    $imagen = 'file-' . $nImg . $ext;
                    $adapter = $form->getElement('file')->getTransferAdapter();
                    $adapter->addFilter('Rename', array(
                        'target' => APPLICATION_PATH . '/../public/dinamic/capacitacion/' . $imagen,
                        'overwrite' => true
                    ));
                    if ($adapter->receive())
                        $properties['_imagen'] = $imagen;
                }
                $capacitacion->setProperties($properties);
                if ($capacitacion->insert()) {
                    $this->getMessenger()->success('Capacitación registrada correctamente');
                    $this->_redirect(BASE_URL . '/administracion/capacitacion');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                    $this->_redirect(BASE_URL . '/administracion/capacitacion');
                }
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-capacitacion-editar.js');
        $this->view->title = "Editar Capacitación";
        $form = new Application_Form_EditarCapacitacionForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $capacitacion = new Application_Entity_Capacitacion();
                $properties['_id'] = $form->getValue('capacitacion');
                $properties['_titulo'] = $form->getValue('titulo');
                $properties['_fecha'] = $form->getValue('fecha');
                $properties['_asiste'] = $form->getValue('asiste');
                $properties['_trainer'] = $form->getValue('trainer');
                $properties['_presentacion'] = $params['txtPresentacion'];
                $properties['_beneficios'] = $params['txtBeneficios'];
                $properties['_contenido'] = $params['txtContenido'];
                $properties['_info'] = $params['txtInfo'];

                $file = $form->getValue('file');

                if (isset($file)) {
                    $nImg = time() . rand(1, 100);
                    $ext = '.' . pathinfo($file, PATHINFO_EXTENSION);
                    $imagen = 'file-' . $nImg . $ext;
                    $adapter = $form->getElement('file')->getTransferAdapter();
                    $adapter->addFilter('Rename', array(
                        'target' => APPLICATION_PATH . '/../public/dinamic/capacitacion/' . $imagen,
                        'overwrite' => true
                    ));
                    if ($adapter->receive())
                        $properties['_imagen'] = $imagen;
                }
                $capacitacion->setProperties($properties);
                if ($capacitacion->update()) {
                    $this->getMessenger()->success('Capacitación actualizada correctamente');
                    $this->_redirect(BASE_URL . '/administracion/capacitacion');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en la actualización, Por favor ponganse en contacto con el administrador');
                    $this->_redirect(BASE_URL . '/administracion/capacitacion');
                }
            }
        }

        $capacitacion = new Application_Entity_Capacitacion();
        $data = $capacitacion->identify((int) $params['id']);
        //var_dump($data); exit;
        $fecha = new Zend_Date($data['capacitacion_fecha'], 'YYYY-MM-dd');
        $form->getElement('capacitacion')->setValue($data['capacitacion_id']);
        $form->getElement('fecha')->setValue($fecha->get('dd-MM-YYYY'));
        $form->getElement('trainer')->setValue($data['trainer_id']);
        $form->getElement('asiste')->setValue($data['capacitacion_asiste']);
        $form->getElement('titulo')->setValue($data['capacitacion_titulo']);
        $this->view->form = $form;
        $this->view->capacitacion = $data;
    }

}
