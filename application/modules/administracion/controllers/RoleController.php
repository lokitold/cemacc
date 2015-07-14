<?php

class Administracion_RoleController extends Core_Controller_ActionAdministracion {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headTitle('Roles');
        $this->view->listRole = Application_Entity_Role::getAllRoles();
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-role-index.js');
        $this->view->headLink()->setStylesheet(STATIC_URL . '/application/css/administracion-role-nuevo.css');
    }

    public function nuevoAction() {
        $this->view->headTitle('Nuevo Rol');
        $form = new Application_Form_NuevoRol();
        $this->view->tree = Application_Entity_Resource::getAdminResource();
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-role-nuevo.js');
        $this->view->headLink()->setStylesheet(STATIC_URL . '/application/css/administracion-role-nuevo.css');
        $this->view->resourceSelected = array();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->_getAllParams())) {
                $objRol = new Application_Entity_Role();
                $objRol->setPropertie('_nombre', $form->getElement('nombre')->getValue());
                $objRol->setPropertie('_descripcion', $form->getElement('descripcion')->getValue());
                $objRol->insert();
                $permisos = implode(',', $this->getParam('resource'));
                $objRol->insertPermisos($permisos);
                $this->getMessenger()->success('El Rol se registro correctamente');
                $this->_redirect('/administracion/role/');
            } else {
                $this->view->resourceSelected = $this->_getParam('resource', array());
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $this->view->headTitle('Editar Rol');
        $this->view->id = $id = $this->getParam('id', '');
        $form = new Application_Form_NuevoRol();
        $objRol = new Application_Entity_Role();
        $objRol->identify($id);
        $this->view->tree = Application_Entity_Resource::getAdminResource();
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-role-nuevo.js');
        $this->view->headLink()->setStylesheet(STATIC_URL . '/application/css/administracion-role-nuevo.css');
        $resourceNat = $objRol->getPermisos();
        $resource = array();
        foreach ($resourceNat as $index) {
            $resource[] = $index['resource_id'];
        }
        $this->view->resourceSelected = $resource;

        $values['nombre'] = $objRol->getPropertie('_nombre');
        $values['descripcion'] = $objRol->getPropertie('_descripcion');

        $form->populate($values);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->_getAllParams())) {
                $objRol->setPropertie('_nombre', $form->getElement('nombre')->getValue());
                $objRol->setPropertie('_descripcion', $form->getElement('descripcion')->getValue());
                $objRol->update();
                $permisos = implode(',', $this->getParam('resource'));
                $objRol->updatePermisos($permisos);
                $this->getMessenger()->success('El Rol se Actualizo Correctamente');
                $this->_redirect('/administracion/role/');
            } else {
                $this->view->resourceSelected = $this->_getParam('resource', array());
            }
        }
        $this->view->form = $form;
    }

    public function eliminarAction() {
        $id = (int) $this->getParam('id', '');
        if ($id <= 0) {
            $this->getMessenger()->error('Datos incorrectos');
            $this->_redirect('/administracion/role/');
        }
        $objRol = new Application_Entity_Role();
        $objRol->identify($id);
        if ($objRol->eliminar()){
            $this->getMessenger()->success('El Rol se Elimino Correctamente');
        }else{
            $this->getMessenger()->error($objRol->getMessage());
        }
        
        $this->_redirect('/administracion/role/');
    }

    public function activarAction() {
        $id = $this->getParam('id', '');
        if ($id <= 0) {
            $this->getMessenger()->error('Datos incorrectos');
            $this->_redirect('/administracion/role/');
        }
        $objRol = new Application_Entity_Role();
        $objRol->identify($id);
        $flag = $this->getParam('flag', '');
        if ($flag == 1) {
            $objRol->activar();
            $this->getMessenger()->success('El Rol se activó Correctamente');
            $this->_redirect('/administracion/role/');
        } else {
            if ($objRol->desactivar()) {
                $this->getMessenger()->success('El Rol se desactivó Correctamente');
            }else{
                $this->getMessenger()->error($objRol->getMessage());
            }
            $this->_redirect('/administracion/role/');
        }
    }

    function verPermisosAction() {
        $this->_helper->layout->setLayout('layout_clear');
        $this->view->id = $id = $this->getParam('id', '');
        $objRol = new Application_Entity_Role();
        $objRol->identify($id);
        $this->view->tree = Application_Entity_Resource::getAdminResource();
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-role-nuevo.js');
        $this->view->headLink()->setStylesheet(STATIC_URL . '/application/css/administracion-role-nuevo.css');
        $resourceNat = $objRol->getPermisos();
        $resource = array();
        foreach ($resourceNat as $index) {
            $resource[] = $index['resource_id'];
        }
        $this->view->resourceSelected = $resource;
    }

}
