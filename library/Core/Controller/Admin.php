<?php

class Core_Controller_Admin extends Core_Controller_Action {

    public function init() {
        parent::init();
        $this->_helper->layout->setLayout('layout_intranet');
        $this->view->layoutUsuario = $this->_identity;
        $this->view->navigation($this->getMenuMain());
    }

    function getMenuMain(){
        $container = new Zend_Navigation(array(
            array(
                'label' => 'My Abogado',
                'uri' =>  BASE_URL.'/miabogado',
                'id' =>  1,
                ),
            array(
                'label' => 'Buscar Viaje',
                'uri' =>  BASE_URL.'/miabogado/buscar-viaje',
                'id' =>  2,
                ),
            array(
                'label' => 'Publicar Viaje',
                'uri' =>  BASE_URL.'/miabogado/publicar-viaje',
                'id' =>  3,
                ),
            array(
                'label' => 'Mis Autos',
                'uri' =>  BASE_URL.'/miabogado/mis-autos',
                'id' =>  4,
                ),
            array(
                'label' => 'Mis Viajes',
                'uri' =>  BASE_URL.'/miabogado/mis-viajes',
                'id' =>  5,
                ),
            array(
                'label' => 'Mi Perfil',
                'uri' =>  BASE_URL.'/miabogado/informacion-personal',
                'id' =>  6,
                ),
        ));
        return $container;
    }
    function gadgetMenuMiCuenta() {
        if ($this->_objectUser->getPropertie('_flagValidado') == 1) {
            $options = array(
                'nameMenu' => 'Informacion Personal',
                'menu' => array(
                    array('module' => 'miabogado', 'controller' => 'informacion-personal', 'action' => 'index', 'label' => 'Información Personal'),
                    array('module' => 'miabogado', 'controller' => 'informacion-personal', 'action' => 'preferencias', 'label' => 'Preferencias'),
                    array('module' => 'miabogado', 'controller' => 'informacion-personal', 'action' => 'visibilidad', 'label' => 'Visibilidad'),
                    array('module' => 'miabogado', 'controller' => 'informacion-personal', 'action' => 'estadisticas', 'label' => 'Estadísticas'),
                ),
            );
        } else {
            $options = array(
                'nameMenu' => 'Informacion Personal',
                'menu' => array(
                    array('module' => 'miabogado', 'controller' => 'informacion-personal', 'action' => 'index', 'label' => 'Información Personal'),
                    array('module' => 'miabogado', 'controller' => 'informacion-personal', 'action' => 'validacion-cuenta', 'label' => 'Validación de Cuenta'),
                    array('module' => 'miabogado', 'controller' => 'informacion-personal', 'action' => 'preferencias', 'label' => 'Preferencias'),
                    array('module' => 'miabogado', 'controller' => 'informacion-personal', 'action' => 'visibilidad', 'label' => 'Visibilidad'),
                    array('module' => 'miabogado', 'controller' => 'informacion-personal', 'action' => 'estadisticas', 'label' => 'Estadísticas'),
                ),
            );
        }
        $this->_helper->addGadget('menuIzquierda', $options);
        if ($this->_objectUser->getPropertie('_facebookId')) {
            $options = array(
                'nameMenu' => 'Cuenta',
                'menu' => array(
                    array('module' => 'miabogado', 'controller' => 'cuenta', 'action' => 'notificaciones', 'label' => 'Notificaciones'),
                    array('module' => 'miabogado', 'controller' => 'cuenta', 'action' => 'compartir', 'label' => 'Compartir'),
                    array('module' => 'miabogado', 'controller' => 'cuenta', 'action' => 'eliminar-cuenta', 'label' => 'Eliminar Cuenta'),
                ),
            );
        } else {
            $options = array(
                'nameMenu' => 'Cuenta',
                'menu' => array(
                    array('module' => 'miabogado', 'controller' => 'cuenta', 'action' => 'notificaciones', 'label' => 'Notificaciones'),
                    array('module' => 'miabogado', 'controller' => 'cuenta', 'action' => 'compartir', 'label' => 'Compartir'),
                    array('module' => 'miabogado', 'controller' => 'cuenta', 'action' => 'contrasena', 'label' => 'Contraseña'),
                    array('module' => 'miabogado', 'controller' => 'cuenta', 'action' => 'eliminar-cuenta', 'label' => 'Eliminar Cuenta'),
                ),
            );
        }

        $this->_helper->addGadget('menuIzquierda', $options);
    }

}