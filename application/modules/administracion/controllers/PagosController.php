<?php

class Administracion_PagosController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headTitle('Pagos');
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-usuario-index.js');
        $this->view->pagos = Application_Entity_CompraSaldo::getAllCompraSaldo();
    }

    public function nuevoAction() {
        $this->view->headTitle('Nuevo Usuario');
        $form = new Application_Form_NuevoUsuarioForm();
        $params = $this->_getAllParams();

        if ($this->getRequest()->isPost()) {
//var_dump($params);                exit();
            if ($form->isValid($params)) {
                
                $implicado = new Application_Entity_Implicado();
                $implicado->setProperties(array(
                    '_tipoDocumento' => $form->getValue('tipoDocumento'),
                    '_numeroDocumento' => $form->getValue('nroDocumento'),
                    '_nombres' => $form->getValue('nombres'),
                    '_apellidoPaterno' => $form->getValue('apellidoPaterno'),
                    '_apellidoMaterno' => $form->getValue('apellidoMaterno'),
                    '_email' => $form->getValue('email'),
                    '_direccion' => $form->getValue('direccion'),
                    '_telefono' => $form->getValue('telefono'),
                    '_celular' => $form->getValue('celular'),
                    '_numeroColegiatura' => $form->getValue('nroColegiatura'),
                ));
                $id = $implicado->insert();

                $usuario = new Application_Entity_Usuario();
                $usuario->setProperties(array(
                    '_implicado' => $id,
                    '_usuario' => $form->getValue('usuario'),
                    '_rol' => $form->getValue('rol'),
                ));

                if ($usuario->insert()) {
                    $this->getMessenger()->success('Usuario Registrado');
                    $this->_redirect(BASE_URL.'/administracion/usuario');
                } else {
                    $this->getMessenger()->error('Error al registrar usuario');
                    $this->_redirect(BASE_URL.'/administracion/usuario');
                }
            }
        }
        $this->view->form = $form;
    }

    public function editarAction() {
        $this->view->headTitle('Editar Usuario');
        $form = new Application_Form_EditarUsuarioForm();
        $params = $this->_getAllParams();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $implicado = new Application_Entity_Implicado();
                $implicado->setProperties(array(
                    '_id' => (int) $params['implicado_id'],
                    '_tipoDocumento' => $form->getValue('tipoDocumento'),
                    '_numeroDocumento' => $form->getValue('nroDocumento'),
                    '_nombres' => $form->getValue('nombres'),
                    '_apellidoPaterno' => $form->getValue('apellidoPaterno'),
                    '_apellidoMaterno' => $form->getValue('apellidoMaterno'),
                    '_email' => $form->getValue('email'),
                    '_direccion' => $form->getValue('direccion'),
                    '_telefono' => $form->getValue('telefono'),
                    '_celular' => $form->getValue('celular'),
                    '_numeroColegiatura' => $form->getValue('nroColegiatura'),
                ));
                $implicado->update();

                $usuario = new Application_Entity_Usuario();
                $usuario->setProperties(array(
                    '_id' => (int) $params['usuario_id'],
                    '_implicado' => (int) $params['implicado_id'],
                    '_usuario' => $form->getValue('usuario'),
                    '_rol' => $form->getValue('rol'),
                ));
                if ($usuario->update() !== false) {
                    $this->getMessenger()->success('Usuario Actualizado');
                    $this->_redirect(BASE_URL.'/administracion/usuario');
                } else {
                    $this->getMessenger()->error('Error al actualizar datos de usuario');
                    $this->_redirect(BASE_URL.'/administracion/usuario');
                }
            }
        }
        $usuario = new Application_Entity_Usuario();
        $data = $usuario->identify((int) $params['id']);
        if (empty($data)) {
            $this->getMessenger()->error('Usuario no encontrado');
            $this->_redirect('/administracion/usuario');
        }
        $form->getElement('usuario_id')->setValue($data['usuario_id']);
        $form->getElement('implicado_id')->setValue($data['implicado_id']);
        $form->getElement('tipoDocumento')->setValue($data['implicado_tipo_documento']);
        $form->getElement('nroDocumento')->setValue($data['implicado_numero_documento']);
        $form->getElement('nombres')->setValue($data['implicado_nombre']);
        $form->getElement('apellidoPaterno')->setValue($data['implicado_apellido_paterno']);
        $form->getElement('apellidoMaterno')->setValue($data['implicado_apellido_materno']);
        $form->getElement('email')->setValue($data['implicado_email']);
        $form->getElement('usuario')->setValue($data['usuario_identity']);
        $form->getElement('direccion')->setValue($data['implicado_direccion']);
        $form->getElement('telefono')->setValue($data['implicado_telefono']);
        $form->getElement('celular')->setValue($data['implicado_celular']);
        $form->getElement('nroColegiatura')->setValue($data['implicado_numero_colegiatura']);
        $form->getElement('rol')->setValue($data['role_id']);

        $this->view->form = $form;
    }

    public function eliminarAction() {
        $params = $this->_getAllParams();
        if (Application_Entity_Usuario::eliminar((int) $params['id'])) {
            $this->getMessenger()->success('Usuario Eliminado');
            $this->_redirect(BASE_URL.'/administracion/usuario');
        } else {
            $this->getMessenger()->error('El accesorio no existe o esta siendo utilizado por la aplicación');
            $this->_redirect(BASE_URL.'/administracion/usuario');
        }
    }

    public function confirmarAction() {
        $params = $this->_getAllParams();
        if (Application_Entity_CompraSaldo::confirmar((int) $params['id'])) {
            $this->getMessenger()->success('Se realizó correctaente la confirmación del pago');
            $this->_redirect(BASE_URL.'/administracion/pagos');
        } else {
            $this->getMessenger()->error('No se puedo realizar la confirmación del pago');
            $this->_redirect(BASE_URL.'/administracion/pagos');
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

}