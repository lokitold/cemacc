<?php

class Administracion_PaqueteController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headTitle('Paquetes');
        $this->view->paquete = Application_Entity_Paquete::getAllPaquete();
    }

    public function nuevoAction() {
        $this->view->headTitle('Nuevo Usuario');
        $form = new Application_Form_NuevoPaqueteForm();
        $params = $this->_getAllParams();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {

                $paquete = new Application_Entity_Paquete();
                $paquete->setProperties(array(
                    '_nombre' => $form->getValue('nombre'),
                    '_dias' => $form->getValue('dias'),
                    '_precio' => $form->getValue('precio'),
                    '_dimension' => $form->getValue('dimension'),
                ));
                if ($paquete->insert()) {
                    $this->getMessenger()->success('Paquete Registrado');
                    $this->_redirect(BASE_URL . '/administracion/paquete');
                } else {
                    $this->getMessenger()->error('Error al registrar paquete');
                    $this->_redirect(BASE_URL . '/administracion/paquete');
                }
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $this->view->headTitle('Nuevo Usuario');
        $form = new Application_Form_EditarPaqueteForm();
        $params = $this->_getAllParams();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {

                $paquete = new Application_Entity_Paquete();
                $paquete->setProperties(array(
                    '_id' => $form->getValue('paquete'),
                    '_nombre' => $form->getValue('nombre'),
                    '_dias' => $form->getValue('dias'),
                    '_precio' => $form->getValue('precio'),
                    '_dimension' => $form->getValue('dimension'),
                ));
                if ($paquete->update()) {
                    $this->getMessenger()->success('Paquete Actualizado');
                    $this->_redirect(BASE_URL . '/administracion/paquete');
                } else {
                    $this->getMessenger()->error('Error al actualizar paquete');
                    $this->_redirect(BASE_URL . '/administracion/paquete');
                }
            }
        }

        $paquete = new Application_Entity_Paquete();
        $data = $paquete->identify((int) $params['id']);

        $form->getElement('nombre')->setValue($data['paquete_nombre']);
        $form->getElement('dias')->setValue($data['paquete_dias']);
        $form->getElement('paquete')->setValue($data['paquete_id']);
        $form->getElement('precio')->setValue($data['paquete_precio']);
        $form->getElement('dimension')->setValue($data['paquete_dimension']);


        $this->view->form = $form;
    }

    public function eliminarAction() {
        $params = $this->_getAllParams();
        if (Application_Entity_Usuario::eliminar((int) $params['id'])) {
            $this->getMessenger()->success('Usuario Eliminado');
            $this->_redirect(BASE_URL . '/administracion/usuario');
        } else {
            $this->getMessenger()->error('El accesorio no existe o esta siendo utilizado por la aplicación');
            $this->_redirect(BASE_URL . '/administracion/usuario');
        }
    }

    public function confirmarAction() {
        $params = $this->_getAllParams();
        if (Application_Entity_CompraSaldo::confirmar((int) $params['id'])) {
            $this->getMessenger()->success('Se realizó correctaente la confirmación del pago');
            $this->_redirect(BASE_URL . '/administracion/pagos');
        } else {
            $this->getMessenger()->error('No se puedo realizar la confirmación del pago');
            $this->_redirect(BASE_URL . '/administracion/pagos');
        }
    }

    public function getUsuarioDataAjaxAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $usuario = new Application_Entity_UsuarioSistema();
            $this->_helper->json($usuario->identify((int) $this->getParam('id')));
        }
    }

    public function verAction() {
        $usuario = new Application_Entity_Usuario();
        $this->view->usuario = $usuario->identify((int) $this->getParam('id'));
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->setLayout('layout_clear');
        }
    }

    public function activarAction() {
        $paquete = new Application_Entity_Paquete();
        $id = (int) $this->_getParam('id', 0);
        $estado = (int) $this->_getParam('flag', 0);

        if ($paquete->activar($id, $estado) !== false) {
            $this->getMessenger()->success('El Paquete ha sido activado/desactivado');
        } else {
            $this->getMessenger()->error('Hubo un Problema al realizar esta acción, por favor póngase en contacto con el administrador');
        }
        $this->_redirect('/administracion/paquete');
    }

}
