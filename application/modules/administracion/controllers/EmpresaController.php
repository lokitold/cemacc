<?php

class Administracion_EmpresaController extends Core_Controller_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headTitle('Empresas');
        $this->view->empresa = Application_Entity_Empresa::getAllEmpresa();
    }

    public function nuevoAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-empresa-nuevo.js');
        $this->view->title = "Nuevo Pre-Registro";
        $form = new Application_Form_NuevaEmpresaAdministracionForm();
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $empresa = new Application_Entity_Empresa();
                $properties['_nombreComercial'] = $form->getValue('nombreComercial');
                $properties['_razonSocial'] = $form->getValue('razonSocial');
                $properties['_ruc'] = $form->getValue('numeroRuc');
                $properties['_idCategoria'] = $form->getValue('categoria');
                $properties['_idSubcategoria'] = (int) $params['subcategoria'];
                $empresa->setProperties($properties);
                $idEmpresa = $empresa->insert();

                $ubicacion = new Application_Entity_Ubicacion();
                $propertiesUb['_pais'] = (int) $params['pais'];
                $propertiesUb['_ubigeo'] = (int) $params['idUbigeo'];
                $propertiesUb['_direccion'] = $form->getValue('direccion');
                $propertiesUb['_empresa'] = $idEmpresa;
                $ubicacion->setProperties($propertiesUb);

                if ($ubicacion->insert()) {
                    $this->getMessenger()->success('La Empresa se registro correctamente');
                    $this->_redirect(BASE_URL . '/administracion/empresa');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en el registro, Por favor ponganse en contacto con el administrador');
                    $this->_redirect(BASE_URL . '/administracion/empresa');
                }
            }
        }
        $this->view->form = $form;
        $this->view->departamentos = Application_Entity_Ubigeo::getAllDepartamento();
    }

    public function editarAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/administracion-empresa-nuevo.js');
        $this->view->title = "Editar Empresa";
        $params = $this->_getAllParams();
        $empresa = new Application_Entity_Empresa();
        $data = $empresa->identify((int) $params['id']);
        $form = new Application_Form_EditarEmpresaAdministracionForm(array(
            'categoria' => $empresa->getPropertie('_idCategoria'),
            'pais' => $data['pais_id'],
            'departamento' => $data['departamento'],
            'provincia' => $data['provincia']));

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($params)) {
                $empresa = new Application_Entity_Empresa();
                $properties['_id'] = $form->getValue('empresa');
                $properties['_nombreComercial'] = $form->getValue('nombreComercial');
                $properties['_razonSocial'] = $form->getValue('razonSocial');
                $properties['_ruc'] = $form->getValue('numeroRuc');
                $properties['_idCategoria'] = $form->getValue('categoria');
                $properties['_idSubcategoria'] = $form->getValue('subcategoria');
                $empresa->setProperties($properties);
                $res1 = $empresa->update();

                $ubicacion = new Application_Entity_Ubicacion();
                $propertiesUb['_id'] = $form->getValue('ubicacion');
                $propertiesUb['_pais'] = $form->getValue('pais');
                $propertiesUb['_ubigeo'] = $form->getValue('ubigeo');
                $propertiesUb['_direccion'] = $form->getValue('direccion');
                $propertiesUb['_empresa'] = $form->getValue('empresa');
                $ubicacion->setProperties($propertiesUb);
                $res2 = $ubicacion->update();

                if ($res1 || $res2) {
                    $this->getMessenger()->success('Los datos de la Empresa se actualizaron correctamente');
                    $this->_redirect(BASE_URL . '/administracion/empresa');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en la actualización, Por favor ponganse en contacto con el administrador');
                    $this->_redirect(BASE_URL . '/administracion/empresa');
                }
            }
        }



        $form->getElement('empresa')->setValue($data['empresa_id']);
        $form->getElement('nombreComercial')->setValue($data['empresa_nombre_comercial']);
        $form->getElement('numeroRuc')->setValue($data['empresa_ruc']);
        $form->getElement('categoria')->setValue($data['categoria_id']);
        $form->getElement('subcategoria')->setValue($data['subcategoria_id']);
        $form->getElement('razonSocial')->setValue($data['empresa_razon_social']);
        $form->getElement('pais')->setValue($data['pais_id']);
        $form->getElement('departamento')->setValue($data['departamento']);
        $form->getElement('ubicacion')->setValue($data['ubicacion_id']);
        $form->getElement('provincia')->setValue($data['provincia']);
        $form->getElement('distrito')->setValue($data['distrito']);
        $form->getElement('ubigeo')->setValue($data['ubigeo_id']);
        $form->getElement('direccion')->setValue($data['ubicacion_direccion']);


        $this->view->form = $form;
        $this->view->departamentos = Application_Entity_Ubigeo::getAllDepartamento();
    }
    
    public function activarAction() {
        $empresa = new Application_Entity_Empresa();
        $id = (int)$this->_getParam('id',0);
        $estado = (int)$this->_getParam('flag',0);
       
        if ($empresa->activar($id,$estado) !== false) {
            $this->getMessenger()->success('La Empresa ha sido activado/desactivado');
        } else {
            $this->getMessenger()->error('Hubo un Problema al realizar esta acción, por favor póngase en contacto con el administrador');
        }
        $this->_redirect('/administracion/empresa');
    }

}
