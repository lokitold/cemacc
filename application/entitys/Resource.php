<?php

class Application_Entity_Resource extends Core_Entity {

    static function getAllResource() {

        $perfil = array(
            'label' => 'Perfil',
            'action' => 'index',
            'controller' => 'perfil',
            'module' => 'default',
            'resource' => 'default-index-perfil',
            'title' => 'Perfil',
            'flagNavigation' => 1,
            'flagAdminResource' => 0,
            'id' => 1,
            'pages' => array(
                array(
                    'label' => 'Editar',
                    'action' => 'editar',
                    'controller' => 'perfil',
                    'module' => 'default',
                    'resource' => 'default-perfil-editar',
                    'title' => 'Editar Perfil',
                    'flagNavigation' => 1,
                    'flagAdminResource' => 0,
                    'id' => 10,
                ),
                array(
                    'label' => 'Cambiar Contraseña',
                    'action' => 'cambiar-contrasena',
                    'controller' => 'perfil',
                    'module' => 'default',
                    'resource' => 'default-perfil-cambiar-contrasena',
                    'title' => 'Cambiar Contraseña',
                    'flagNavigation' => 1,
                    'flagAdminResource' => 0,
                    'id' => 11,
                )
            )
        );
        
            
        return array(
            $perfil,
            array(
                'label' => 'Salir',
                'action' => 'index',
                'controller' => 'logout',
                'module' => 'default',
                'resource' => 'default-logout-index',
                'flagNavigation' => 1,
                'flagAdminResource' => 0,
            ),
        );
    }

    static function cleanResource($indexClean = 'flagNavigation') {
        $array = self::getAllResource();
        foreach ($array as $index => $value) {
            if ($value[$indexClean] == 0) {
                unset($array[$index]);
                continue;
            }
            if (isset($value['pages'])) {
                foreach ($value['pages'] as $index2 => $value2) {
                    if ($value2[$indexClean] == 0) {
                        unset($array[$index]['pages'][$index2]);
                    }
                }
            }
        }
        return $array;
    }

    static function getNavigation() {
        return self::cleanResource('flagNavigation');
    }

    static function getAdminResource() {
        return self::cleanResource('flagAdminResource');
    }

}