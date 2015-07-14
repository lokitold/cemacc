<?php

class Logistica_AdquisicionProductoController extends Core_Controller_Logistica {

    public function init() {
        parent::init();
    }

    public function nuevoAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/logistica-adquisicion-producto-nuevo.js');
        $this->view->title = "Adquirir Productos";
        $this->view->headTitle($this->view->title, 'APPEND');
        $form = new Application_Form_NuevaAdquisicionLogisticaForm();
         $params = $this->_getAllParams();
         
        if ($this->getRequest()->isPost()) {
                $adquisicion = new Application_Entity_Adquisicion();
                $properties['_tipo'] = '1';
                $properties['_empresaId'] = $this->_identity->empresa_id;
                $properties['_fechaLimite'] = $params['fechaLimite'];
                $properties['_empresaEnvio'] = $params['empresaEnvio'];
                $adquisicion->setProperties($properties);
                $idAdquisicion = $adquisicion->insert();
                $dataProducto = explode(",", $params['dataProducto']);
                
                
                foreach($dataProducto as $val){
                    
                    $data = explode("|",$val);
                $adquisicionDetalle = new Application_Entity_AdquisicionDetalle();    
                $propertiesAd['_adquisicionId'] = $idAdquisicion;
                $propertiesAd['_nombre'] = $data[0];
                $propertiesAd['_descripcion'] = $data[1];
                $propertiesAd['_cantidad'] = $data[2];
                $propertiesAd['_precio'] = $data[3];
                $adquisicionDetalle->setProperties($propertiesAd);
                //var_dump($propertiesAd);
                $idAD = $adquisicionDetalle->insert();
                }
                //exit();
                if ($idAD) {
                    $adquisicion->prepareMail($params['tblHtml']);
                    $this->getMessenger()->success('Se realizó el envio correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un Problema con el envio, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect(BASE_URL.'/logistica/adquisicion-producto/');
        }

        $this->view->form = $form;
    }

}
