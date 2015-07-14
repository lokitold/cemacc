<?php

class Empresa_InformacionController extends Core_Controller_Empresa {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/empresa-informacion-index.js');
        $this->view->headTitle('Bienvenidos');

        $empresa = new Application_Entity_Empresa();
        $data = $empresa->identify($this->_identity->empresa_id);
        $form = new Application_Form_EmpresaInformacionForm(array(
            'categoria' => $empresa->getPropertie('_idCategoria'),
            'pais' => $data['pais_id'],
            'departamento' => $data['departamento'],
            'provincia' => $data['provincia'],
        ));
        $params = $this->_getAllParams();
        if ($this->getRequest()->isPost()) {

            if ($form->isValid($params)) {
                //var_dump($form); exit();
                $empresa = new Application_Entity_Empresa();
                $properties['_id'] = $form->getValue('empresa');
                $properties['_nombreComercial'] = $form->getValue('nombreComercial');
                $properties['_razonSocial'] = $form->getValue('razonSocial');
                $properties['_ruc'] = $form->getValue('numeroRuc');
                $properties['_website'] = $form->getValue('website');
                $properties['_idCategoria'] = $form->getValue('categoria');
                $properties['_idSubcategoria'] = $form->getValue('subcategoria');
                
                //imagenes
                $adapter = new Zend_File_Transfer_Adapter_Http();
                foreach ($adapter->getFileInfo() as $file => $info) {
                    if($file == 'imagen_0_'){
                    $pre = "imagen-";
                    $path = APPLICATION_PATH . "/../public/dinamic/empresa/imagen/";
                    $proIndex = "_imagen";
                }else{
                    $pre = "logo-";
                    $path = APPLICATION_PATH . "/../public/dinamic/empresa/logo/";
                    $proIndex = "_logo";
                }
                    if ($adapter->isUploaded($file)) {
                        $nImg = time() . rand(1, 100);
                $ext = '.' . pathinfo($info['name'], PATHINFO_EXTENSION);
                $img = $pre . $nImg . $ext;
                        $name = $adapter->getFileName($file);
                        $fname = $path . $img;
                        /**
                         *  Let's inject the renaming filter
                         */
                        $adapter->addFilter(new Zend_Filter_File_Rename(
                                array(
                                    'target' => $fname,
                                    'overwrite' => true)),
                                    null, 
                                    $file);
                        /**
                         * And then we call receive manually
                         */
                        if($adapter->receive($file)){
                            $properties[$proIndex] = $img;
                        }
                        
                    }
                }

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
                    $this->_redirect(BASE_URL . '/empresa/informacion');
                } else {
                    $this->getMessenger()->error('Hubo un Problema en la actualización, Por favor ponganse en contacto con el administrador');
                    $this->_redirect(BASE_URL . '/empresa/informacion');
                }
            }
        }
        $form->getElement('empresa')->setValue($empresa->getPropertie('_id'));
        $form->getElement('numeroRuc')->setValue($empresa->getPropertie('_ruc'));
        $form->getElement('nombreComercial')->setValue($empresa->getPropertie('_nombreComercial'));
        $form->getElement('razonSocial')->setValue($empresa->getPropertie('_razonSocial'));
        $form->getElement('categoria')->setValue($empresa->getPropertie('_idCategoria'));
        $form->getElement('subcategoria')->setValue($empresa->getPropertie('_idSubcategoria'));
        $form->getElement('website')->setValue($empresa->getPropertie('_website'));
        $form->getElement('pais')->setValue($data['pais_id']);
        $form->getElement('departamento')->setValue($data['departamento']);
        $form->getElement('ubicacion')->setValue($data['ubicacion_id']);
        $form->getElement('ubigeo')->setValue($data['ubigeo_id']);
        $form->getElement('provincia')->setValue($data['provincia']);
        $form->getElement('distrito')->setValue($data['distrito']);
        $form->getElement('direccion')->setValue($data['ubicacion_direccion']);
        $this->view->empresa = $data;
        $this->view->form = $form;
    }

}
