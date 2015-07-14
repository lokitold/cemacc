<?php

class Application_Model_Role extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param array $data
     * @return int|boolean
     */
    public function insert($data) {
        if (!is_array($data)) {
            return false;
        }
        $tableRole = new Application_Model_DbTable_Role();
        try {
            $tableRole->insert($data);
            $result = $tableRole->getAdapter()->lastInsertId();
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    /**
     * @param int $id
     * @param array $data
     * @return int|boolean
     */
    public function update($id, $data) {
        if (!is_array($data)) {
            return false;
        }
        $tableRole = new Application_Model_DbTable_Role();
        try {
            $where = $tableRole->getAdapter()->quoteInto('role_id =?', $id);
            $result = $tableRole->update($data, $where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    /**
     * @param int $id
     * @return array        
     */
    public function getRole($id = '') {
        $tableRole = new Application_Model_DbTable_Role();
        $smt = $tableRole->select();
        if ($id != '')
            $smt = $smt->where('role_id =?', $id);

        $smt = $smt->where('role_flag_constante =?', '0');
        $smt = $smt->where('role_flag_delete =?', '0');
        try {
            $smt = $smt->query();
            if ($id == '')
                $result = $smt->fetchAll();
            else
                $result = $smt->fetch();
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        $smt->closeCursor();
        return $result;
    }

    /**
     * @return array        
     */
    public function getRoleActivos() {
        $tableRole = new Application_Model_DbTable_Role();
        $smt = $tableRole->select()
                ->where('role_flag_constante =?', '0')
                ->where('role_flag_delete =?', '0')
                ->where('role_activo =?', 1)
        ;

        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

    private function getAllChildrenResource() {
        $tableRecursos = new Application_Model_DbTable_Resource();
        $smt = $tableRecursos->select()->where('resource_children<>""');
        $smt = $tableRecursos->select()->query();
        $recursos = $smt->fetchAll();
        $smt->closeCursor();
        $recursosChildren = array();
        foreach ($recursos as $index) {
            if ($index['resource_children'] != '')
                $recursosChildren[$index['resource_id']] = explode(',', $index['resource_children']);
        }
        return $recursosChildren;
    }

    /**
     * @param int $idRol
     * @param string $permisos
     * @return boolean
     */
    public function insertPermisos($idRol, $permisos) {
        $arrayPermisos = explode(',', $permisos);
        //Core_Log::error(print_r($arrayPermisos,TRUE));
        $tablePermisos = new Application_Model_DbTable_Permission();
        $recursosChildren = $this->getAllChildrenResource();
        //Core_Log::error(print_r($recursosChildren,TRUE));
        if (count($arrayPermisos) > 0) {
            foreach ($arrayPermisos as $index) {
                if (isset($recursosChildren[$index])) {
                    foreach ($recursosChildren[$index] as $index2) {
                        $data ['role_id'] = $idRol;
                        $data ['resource_id'] = $index2;
                        //Core_Log::error('insert Hijo '.print_r($data,TRUE));
                        $tablePermisos->insert($data);
                    }
                }
                $data1 ['role_id'] = $idRol;
                $data1 ['resource_id'] = $index;
                //Core_Log::error('insert Padre '.print_r($data1,TRUE));
                $tablePermisos->insert($data1);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @param int $idRol
     * @param string $permisos
     * @return boolean
     */
    public function updatePermisos($idRol, $permisos) {
        $arrayPermisos = explode(',', $permisos);
        $recursosChildren = $this->getAllChildrenResource();

        $arrayPermisosHis = $this->getPermisos($idRol);
        $permisosHis = array();
        foreach ($arrayPermisosHis as $index) {
            $permisosHis[] = $index['resource_id'];
            if (isset($recursosChildren[$index['resource_id']])) {
                foreach ($recursosChildren[$index['resource_id']] as $index2) {
                    $permisosHis[] = $index2;
                }
            }
        }
        $arrayPermisosTemp = $arrayPermisos;
        foreach ($arrayPermisosTemp as $index) {
            if (isset($recursosChildren[$index])) {
                foreach ($recursosChildren[$index] as $index2) {
                    $arrayPermisos[] = $index2;
                }
            }
        }


        $intersec = array_intersect($arrayPermisos, $permisosHis);
        $idAgregar = array_diff($arrayPermisos, $intersec);
        $idEliminar = array_diff($permisosHis, $intersec);
        $tablePermisos = new Application_Model_DbTable_Permission();
        foreach ($idAgregar as $index) {
            $data ['role_id'] = $idRol;
            $data ['resource_id'] = $index;
            $tablePermisos->insert($data);
        }
        foreach ($idEliminar as $index) {
            $where = array();
            $where[] = $tablePermisos->getAdapter()->quoteInto('resource_id =?', $index);
            $where[] = $tablePermisos->getAdapter()->quoteInto('role_id =?', $idRol);
            $tablePermisos->delete($where);
        }

        return TRUE;
    }

    /**
     * @param string $nombre    
     * @param int $id
     * @return array        
     */
    public function isNombreUnique($nombre, $id = 0) {
        $tableRole = new Application_Model_DbTable_Role();
        $smt = $tableRole->select()
                ->where('role_id <> ?', $id)
                ->where('role_nombre = ?', $nombre);
        $smt = $smt->query();
        $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @param int $idRol
     * @return array        
     */
    public function getPermisos($idRol) {
        $tablePermisos = new Application_Model_DbTable_Permission();
        $smt = $tablePermisos->select()->where('role_id =?', $idRol);
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @param int $rol
     * @return boolean
     */
    public function isRoleUsed($rol) {
        $tableRole = new Application_Model_DbTable_UsuarioSistema();
        $smt = $tableRole->select()
                ->where('usuario_sistema_activo =?', 1)
                ->where('role_id =?', $rol);
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return !empty($result);
    }

}
