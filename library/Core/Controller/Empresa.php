<?php

class Core_Controller_Empresa extends Core_Controller_Action {

    public function init() {
        parent::init();
        $this->_helper->layout->setLayout('layout_intranet');
        $this->view->layoutUsuario = $this->_identity;
        $this->_saldo = Application_Entity_EmpresaPaquete::getSaldoByEmpresa($this->_identity->empresa_id);
        $this->view->saldo = $this->_saldo;
    }
}
