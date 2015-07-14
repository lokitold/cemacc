<?php

class Default_UtilitariosController extends Core_Controller_Default {

    public function init() {
        parent::init();
    }

    public function ajaxGetProvinciaByDepartamentoAction() {
        $this->_helper->json(
                Application_Entity_Ubigeo::getProvinciaByDepartamento($this->_getParam('departamento', 0)));
    }

    public function ajaxGetDistritoByProvinciaAction() {
        $this->_helper->json(
                Application_Entity_Ubigeo::getDistritoByProvincia($this->_getParam('provincia', 0)));
    }

    public function ajaxGetSubcategoriaByCategoriaAction() {
        $this->_helper->json(
                Application_Entity_Subcategoria::getSubcategoriaByCategoria($this->_getParam('categoria', 0)));
    }

    public function ajaxGetUbigeoByCamposAction() {
        $this->_helper->json(
                Application_Entity_Ubigeo::getUbigeoByCampos(
                        $this->_getParam('departamento', 0), $this->_getParam('provincia', 0), $this->_getParam('distrito', 0)
        ));
    }

    public function ajaxGetOrganoAction() {
        $this->_helper->json(
                Application_Entity_OrganoJurisdiccional::getAllByDistrito((int) $this->_getParam('id')));
    }

    public function ajaxGetEspecialidadAction() {
        $this->_helper->json(
                Application_Entity_JuzgadoEspecialidad::getEspecialidadByOrgano((int) $this->_getParam('id')));
    }

    public function ajaxGetSedeAction() {
        $this->_helper->json(
                Application_Entity_Sede::getSedeByEspecialidad((int) $this->_getParam('id')));
    }

    public function ajaxGetJuzgadoAction() {
        $this->_helper->json(
                Application_Entity_Juzgado::getJuzgadoBySede((int) $this->_getParam('id')));
    }

    public function autocompleteAllEmpresasAction() {
        $implicado = new Application_Entity_Empresa();
        $this->_helper->json(
                $implicado->autocompleteEmpresas($this->_getParam('value')));
    }

}
