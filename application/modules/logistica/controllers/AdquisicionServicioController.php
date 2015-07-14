<?php

class Logistica_AdquisicionServicioController extends Core_Controller_Logistica {

    public function init() {
        parent::init();
    }

    public function nuevoAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/logistica-adquisicion-servicio-nuevo.js');
        $this->view->title = "Adquirir Servicios";
        $this->view->headTitle($this->view->title, 'APPEND');
        $form = new Application_Form_NuevaAdquisicionServicioLogisticaForm();
         $params = $this->_getAllParams();
         
        if ($this->getRequest()->isPost()) {
                $adquisicion = new Application_Entity_Adquisicion();
                $properties['_tipo'] = '2';
                $properties['_empresaId'] = $this->_identity->empresa_id;
                $properties['_fechaLimite'] = $params['fechaLimite'];
                $properties['_empresaEnvio'] = $params['empresaEnvio'];
                $adquisicion->setProperties($properties);
                $idAdquisicion = $adquisicion->insert();
                $dataServicio = explode(",", $params['dataServicio']);
                
                
                foreach($dataServicio as $val){
                    
                    $data = explode("|",$val);
                $adquisicionDetalle = new Application_Entity_AdquisicionDetalle();    
                $propertiesAd['_adquisicionId'] = $idAdquisicion;
                $propertiesAd['_nombre'] = $data[0];
                $propertiesAd['_descripcion'] = $data[1];
                $propertiesAd['_precio'] = $data[2];
                $adquisicionDetalle->setProperties($propertiesAd);
                $idAD = $adquisicionDetalle->insert();
                }
                if ($idAD) {
                    $this->getMessenger()->success('Se realizó el envio correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un Problema con el envio, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect(BASE_URL.'/logistica/adquisicion-servicio/');
        }

        $this->view->form = $form;
    }

}
