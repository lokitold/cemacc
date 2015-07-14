<?php

class Application_Entity_Role extends Core_Entity {

    const ROL_CONCESIONARIO = 3;
    const ROL_PROVEEDOR = 4;
    const ROL_ADMINISTRADOR = 5;
    const ROL_DEFAULT = 2;
    const ROL_PUBLIC = 1;

    protected $_id;
    protected $_nombre;
    protected $_descripcion;
    protected $_activo;

    public function identify($id) {
        $service = $this->setService('Role');
        $result = $service->getRole($id);
        $this->setPropertiesDataBase($result);
        return $result;
    }

    public function setPropertiesDataBase($array) {
        $this->_nombre = $array['role_nombre'];
        $this->_id = $array['role_id'];
        $this->_descripcion = $array['role_descripcion'];
        $this->_activo = $array['role_activo'];
    }

    private function setDataBaseProperties() {
        $data = array();
        $data['role_nombre'] = $this->_nombre;
        $data['role_id'] = $this->_id;
        $data['role_extends'] = self::ROL_DEFAULT;
        $data['role_descripcion'] = $this->_descripcion;
        $data['role_activo'] = $this->_activo;
        return $this->cleanArray($data);
    }

    public function insert() {
        $data = $this->setDataBaseProperties();
        $service = $this->setService('Role');
        $this->_id = $service->insert($data);
        if ($this->_id) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function update(){
        $data = $this->setDataBaseProperties();
        $service = $this->setService('Role');
        $result = $service->update($this->_id,$data);
        if ($result!==FALSE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function updatePermisos($permisos){
        $service = $this->setService('Role');
        $result = $service->updatePermisos($this->_id,$permisos);
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    /*
     * param: $permisos ->Se puede Ingresar los permisos separados por comas. 
     */
    public function insertPermisos($permisos) {
        $service = $this->setService('Role');
        $result = $service->insertPermisos($this->_id,$permisos);
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function getPermisos() {
        $service = $this->setService('Role');
        return $service->getPermisos($this->_id);
    }
    public function activar() {
        $service = $this->setService('Role');
        $data['role_activo']=1;
        $result = $service->update($this->_id,$data);
        if ($result!==FALSE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function desactivar() {
        $service = $this->setService('Role');
        $data['role_activo']=0;
        $result = $service->update($this->_id,$data);
        if ($result!==FALSE) {
            return TRUE;
        } else {
            $this->setMessage('Ocurrio un error al eliminar el rol, inténtelo nuevamente.');
            return FALSE;
        }
    }
    public function eliminar() {
        if ($this->isRoleUsed()){
            $this->setMessage('El rol que desea eliminar esta en uso por uno o mas usuarios.');
            return false;
        }
        $service = $this->setService('Role');
        $data['role_flag_delete']='1';
        $result = $service->update($this->_id,$data);
        if ($result!==FALSE) {
            return TRUE;
        } else {
            $this->setMessage('Ocurrio un error al eliminar el rol, inténtelo nuevamente.');
            return FALSE;
        }
    }
    
    private function isRoleUsed(){
        $service = $this->setService('Role');
        return $service->isRoleUsed($this->_id);
        
    }

    static function getAllRoles() {
        $service = self::setService('Role');
        return $service->getRole();
    }
    static function getAllRolesActivos() {
        $service = self::setService('Role');
        return $service->getRoleActivos();
    }
    static function isNombreUnique($nombre,$id=0){
        $service = self::setService('Role');
        return $service->isNombreUnique($nombre,$id);
    }

}