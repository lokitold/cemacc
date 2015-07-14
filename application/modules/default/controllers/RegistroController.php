<?php

class Default_RegistroController extends Core_Controller_Default {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/default-registro-index.js');
        $this->view->title = "Nuevo Registro";
        $this->view->headTitle($this->view->title, 'APPEND');
        $form = new Application_Form_NuevaEmpresaForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                //var_dump($params); exit();
                $empresa = new Application_Entity_Empresa();
                $properties['_nombreComercial'] = $form->getValue('nombreComercial');
                $properties['_razonSocial'] = $form->getValue('razonSocial');
                $properties['_ruc'] = $form->getValue('numeroRuc');
                $properties['_idCategoria'] = $form->getValue('categoria');
                $properties['_idSubcategoria'] = (int) $params['subcategoria'];
                $properties['_flagActivo'] = '1';
                //var_dump($properties); exit();
                if ($params['idEmpresa'] != "") {
                    $properties['_id'] = $params['idEmpresa'];
                    $empresa->setProperties($properties);
                    $idEmpresa = $empresa->update();
                } else {
                    $empresa->setProperties($properties);
                    $idEmpresa = $empresa->insert();
                }
                $ubicacion = new Application_Entity_Ubicacion();
                $propertiesUb['_pais'] = (int) $params['pais'];
                $propertiesUb['_ubigeo'] = (int) $params['idUbigeo'];
                $propertiesUb['_direccion'] = $form->getValue('direccion');
                if ($params['idEmpresa'] != "") {
                    $propertiesUb['_empresa'] = $params['idEmpresa'];
                    $propertiesUb['_id'] = $params['idUbicacion'];
                    $ubicacion->setProperties($propertiesUb);
                    $ubicacion->update();
                } else {
                    $propertiesUb['_empresa'] = $idEmpresa;
                    $ubicacion->setProperties($propertiesUb);
                    $ubicacion->insert();
                }

                $usuarioVen = new Application_Entity_Usuario();
                $propertiesVen['_usuario'] = $form->getValue('correoVentas');
                $propertiesVen['_nombre'] = $form->getValue('nombreVentas');
                $propertiesVen['_apellido'] = $form->getValue('apellidoVentas');
                $propertiesVen['_email'] = $form->getValue('correoVentas');
                if ($params['idEmpresa'] != "") {
                    $propertiesVen['_empresa'] = $params['idEmpresa'];
                } else {
                    $propertiesVen['_empresa'] = $idEmpresa;
                }
                $usuarioVen->setProperties($propertiesVen);
                $idUsuarioVen = $usuarioVen->insert();

                $dataRoleVen = array(
                    'usuario_id' => $idUsuarioVen,
                    'role_id' => '11',
                );
                $res = $usuarioVen->insertUsuarioRole($dataRoleVen);

                if ($params['activoL'] == 1) {

                    $usuarioLog = new Application_Entity_Usuario();
                    $propertiesLog['_usuario'] = $form->getValue('correoLogistica');
                    $propertiesLog['_nombre'] = $form->getValue('nombreLogistica');
                    $propertiesLog['_apellido'] = $form->getValue('apellidoLogistica');
                    $propertiesLog['_email'] = $form->getValue('correoLogistica');
                    if ($params['idEmpresa'] != "") {
                        $propertiesLog['_empresa'] = $params['idEmpresa'];
                    } else {
                        $propertiesLog['_empresa'] = $idEmpresa;
                    }

                    $usuarioLog->setProperties($propertiesLog);
                    $idUsuarioLog = $usuarioLog->insert();

                    $dataRoleLog = array(
                        'usuario_id' => $idUsuarioLog,
                        'role_id' => '12',
                    );
                    $res = $usuarioLog->insertUsuarioRole($dataRoleLog);
                }

                if ($params['activoR'] == 1) {
                    $usuarioRec = new Application_Entity_Usuario();
                    $propertiesRec['_usuario'] = $form->getValue('correoRecursosHumanos');
                    $propertiesRec['_nombre'] = $form->getValue('nombreRecursosHumanos');
                    $propertiesRec['_apellido'] = $form->getValue('apellidoRecursosHumanos');
                    $propertiesRec['_email'] = $form->getValue('correoRecursosHumanos');
                    if ($params['idEmpresa'] != "") {
                        $propertiesRec['_empresa'] = $params['idEmpresa'];
                    } else {
                        $propertiesRec['_empresa'] = $idEmpresa;
                    }

                    $usuarioRec->setProperties($propertiesRec);
                    $idUsuarioRec = $usuarioRec->insert();

                    $dataRoleRec = array(
                        'usuario_id' => $idUsuarioRec,
                        'role_id' => '13',
                    );
                    $res = $usuarioVen->insertUsuarioRole($dataRoleRec);
                }

                $usuarioAdmin = new Application_Entity_Usuario();

                if ($params['admin'] == 1) {
                    $dataRoleAdmin = array(
                        'usuario_id' => $idUsuarioVen,
                        'role_id' => '14',
                    );
                } else if ($params['admin'] == 2) {
                    $dataRoleAdmin = array(
                        'usuario_id' => $idUsuarioLog,
                        'role_id' => '14',
                    );
                } else if ($params['admin'] == 3) {
                    $dataRoleAdmin = array(
                        'usuario_id' => $idUsuarioRec,
                        'role_id' => '14',
                    );
                }

                $res = $usuarioAdmin->insertUsuarioRole($dataRoleAdmin);

                if ($res) {
                    $this->getMessenger()->success('La Empresa se registro correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect(BASE_URL . '/registro/bienvenido');
            }
        }

        $this->view->form = $form;
        $this->view->departamentos = Application_Entity_Ubigeo::getAllDepartamento();
    }

}
