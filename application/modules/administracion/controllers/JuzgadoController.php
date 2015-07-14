<?php

class Administracion_JuzgadoController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->juzgados = Application_Entity_Juzgado::getAllJuzgado();
    }

    public function nuevoAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-juzgado-nuevo.js');
        $form = new Application_Form_NuevoJuzgadoForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $juzgado = new Application_Entity_Juzgado();
                $properties['_nombre'] = $form->getValue('nombre');
                $properties['_sede'] = $form->getValue('sede');
                $properties['_especialidadId'] = $form->getValue('especialidad');
                $properties['_distritoJudicialId'] = $form->getValue('distrito');
                $properties['_organoJurisdiccionalId'] = $form->getValue('organo');
                //var_dump($properties); exit();
                $juzgado->setProperties($properties);
                if ($juzgado->insert() !== false) {
                    $this->getMessenger()->success('El Juzgado se registró correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/juzgado');
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-juzgado-nuevo.js');
        $params = $this->_getAllParams();
        $juzgado = new Application_Entity_Juzgado();
        $dataJuzgado = $juzgado->identify((int) $params['id']);
        $form = new Application_Form_NuevoJuzgadoForm(array(
            'idDistrito' => $dataJuzgado['distrito_judicial_id'],
            'idOrgano' => $dataJuzgado['organo_jurisdiccional_id'],
            'idEspecialidad' => $dataJuzgado['especialidad_id'],
        ));
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $properties['_id'] = $form->getValue('juzgado_id');
                $properties['_nombre'] = $form->getValue('nombre');
                $properties['_sede'] = $form->getValue('sede');
                $properties['_especialidadId'] = $form->getValue('especialidad');
                $properties['_distritoJudicialId'] = $form->getValue('distrito');
                $properties['_organoJurisdiccionalId'] = $form->getValue('organo');
                $juzgado->setProperties($properties);
                if ($juzgado->update() !== false) {
                    $this->getMessenger()->success('El Juzgado fue actualizado correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un al editar datos, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect('/administracion/juzgado');
            }
        }

        if (empty($dataJuzgado)) {
            $this->getMessenger()->error('No se encontró información sobre el juzgado seleccionado');
            $this->_redirect('/administracion/juzgado');
        }
        $form->getElement('juzgado_id')->setValue($juzgado->getPropertie('_id'));
        $form->getElement('nombre')->setValue($juzgado->getPropertie('_nombre'));
        $form->getElement('sede')->setValue($juzgado->getPropertie('_sede'));
        $form->getElement('especialidad')->setValue($juzgado->getPropertie('_especialidadId'));
        $form->getElement('distrito')->setValue($juzgado->getPropertie('_distritoJudicialId'));
        $form->getElement('organo')->setValue($juzgado->getPropertie('_organoJurisdiccionalId'));
        $this->view->form = $form;
    }

    public function ajaxGetOrganoAction() {
        $this->_helper->json(
                Application_Entity_OrganoJurisdiccional::getAllByDistrito((int) $this->_getParam('id')));
    }

    public function ajaxGetEspecialidadAction() {
        $this->_helper->json(
                Application_Entity_JuzgadoEspecialidad::getEspecialidadByOrgano((int) $this->_getParam('id')));
    }

    public function ajaxGetSedeAction() {
        $this->_helper->json(
                Application_Entity_Sede::getSedeByEspecialidad((int) $this->_getParam('id')));
    }
    
    public function activarAction() {
        $params = $this->_getAllParams();
        if (Application_Entity_Juzgado::activar((int) $params['id'], (int) $params['flag'])) {
            $this->getMessenger()->success('Juzgado activado/desactivado');
            $this->_redirect('/administracion/juzgado');
        } else {
            $this->getMessenger()->error('El juzgado no existe');
            $this->_redirect('/administracion/juzgado');
        }
    }

}
