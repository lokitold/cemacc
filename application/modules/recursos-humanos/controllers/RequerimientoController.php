<?php

class RecursosHumanos_RequerimientoController extends Core_Controller_RecursosHumanos {

    public function init() {
        parent::init();
    }

    public function nuevoAction() {
        $this->view->headScript()->appendFile(STATIC_URL . '/application/js/recursos-humanos-requerimiento-nuevo.js');
        $this->view->title = "Requerir Personal";
        $this->view->headTitle($this->view->title, 'APPEND');
        $form = new Application_Form_NuevoRequerimientoRecursosHumanosForm();
         $params = $this->_getAllParams();
         
        if ($this->getRequest()->isPost()) {
                $requerimiento = new Application_Entity_Requerimiento();
                $properties['_empresaId'] = $this->_identity->empresa_id;
                $properties['_fechaLimite'] = $params['fechaLimite'];
                $properties['_empresaEnvio'] = $params['empresaEnvio'];
                $requerimiento->setProperties($properties);
                $idRequerimiento = $requerimiento->insert();
                $dataPersonal = explode(",", $params['dataPersonal']);
                
                
                foreach($dataPersonal as $val){
                    
                $data = explode("|",$val);
                $requerimientoDetalle = new Application_Entity_RequerimientoDetalle();    
                $propertiesReq['_requerimientoId'] = $idRequerimiento;
                $propertiesReq['_puesto'] = $data[0];
                $propertiesReq['_funciones'] = $data[1];
                $propertiesReq['_sueldo'] = $data[2];
                $requerimientoDetalle->setProperties($propertiesReq);
                $idREQ = $requerimientoDetalle->insert();
                }
                if ($idREQ) {
                    $this->getMessenger()->success('Se realizó el envio correctamente');
                } else {
                    $this->getMessenger()->error('Hubo un Problema con el envio, Por favor ponganse en contacto con el administrador');
                }
                $this->_redirect(BASE_URL.'/recursos-humanos/requerimiento');
        }

        $this->view->form = $form;
    }

}
