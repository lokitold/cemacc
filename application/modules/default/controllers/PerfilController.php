<?php

class Default_PerfilController extends Core_Controller_Default {

    public function init() {
        parent::init();
        $this->view->headTitle('Perfil');
    }

    public function indexAction() {
        $form = new Application_Form_EditarPerfilForm();
        $usuario = new Application_Entity_Usuario();
        $usuario->identify($this->_identity->usuario_id);
        if ($this->getRequest()->isPost()) {
            $params = $this->_getAllParams();
            if ($form->isValid($params)) {
                $abogado->setProperties(array(
                    '_nombres' => $form->getValue('nombres'),
                    '_apellidoPaterno' => $form->getValue('apellidoPaterno'),
                    '_apellidoMaterno' => $form->getValue('apellidoMaterno'),
                    '_telefono' => $form->getValue('telefono'),
                    '_celular' => $form->getValue('celular'),
                    '_numeroColegiatura' => $form->getValue('nroColegiatura'),
                    '_email' => $form->getValue('email'),
                    '_direccion' => $form->getValue('direccion'),
                ));
                if ($abogado->update() !== false){
                    $this->getMessenger()->success('Sus datos fueron actualizados correctamente');
                    $this->_redirect('perfil');
                }else{
                    $this->getMessenger()->error('Hubo un error al actualizar sus datos, inténtelo nuevamente');
                    $this->_redirect('perfil');
                }
            }
        } else {
            $form->getElement('nombres')->setValue($abogado->getPropertie('_nombres'));
            $form->getElement('apellidoPaterno')->setValue($abogado->getPropertie('_apellidoPaterno'));
            $form->getElement('apellidoMaterno')->setValue($abogado->getPropertie('_apellidoMaterno'));
            $form->getElement('telefono')->setValue($abogado->getPropertie('_telefono'));
            $form->getElement('celular')->setValue($abogado->getPropertie('_celular'));
            $form->getElement('nroColegiatura')->setValue($abogado->getPropertie('_numeroColegiatura'));
            $form->getElement('email')->setValue($abogado->getPropertie('_email'));
            $form->getElement('direccion')->setValue($abogado->getPropertie('_direccion'));
        }

        $this->view->form = $form;
    }

    public function passwordAction() {
        $this->view->headTitle('Cambiar Contraseña');
        $form = new Application_Form_CambiarContrasenaForm();
        if ($this->getRequest()->isPost()) {
            $params = $this->_getAllParams();
            if ($form->isValid($params)) {
                $usuario = new Application_Entity_Usuario();
                $usuario->setProperties(array(
                    '_id' => $this->_identity->usuario_id,
                    '_password' => $form->getValue('contrasenaNueva'),
                ));
                if ($usuario->actualizarContrasena()) {
                    $this->getMessenger()->success('Su contraseña ha sido actualizada');
                    $this->_redirect('/perfil/password');
                } else {
                    $this->getMessenger()->success('Hubo en error al cambiar su contraseña, inténtelo nuevamente');
                    $this->_redirect('/perfil/password');
                }
            }
        }
        $form->getElement('usuario')->setValue($this->_identity->implicado_id);
        $this->view->form = $form;
    }

}
