<?php

class Application_Model_Usuario extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idUsuario    
     * @param int $notinRole    
     * @return array        
     */
    public function getUsuario($idUsuario = '', $notinRole = '') {
        $tableUsuario = new Application_Model_DbTable_Usuario();
        $smt = $tableUsuario->getAdapter()->select()
                ->from(array('u' => 'usuario'), array(
                    'u.usuario_id',
                    'u.usuario_flag_activo',
                    'u.usuario_identity',
                    'u.usuario_password',
                    'u.usuario_hash',
                    'u.usuario_nombres',
                    'u.usuario_apellidos',
                    'u.usuario_email',
                    'u.empresa_id',
                    'r.role_id',
                    'r.role_nombre',
                    
                    
                ))
                ->join(array('ur' => 'usuario_role'), 'ur.usuario_id = u.usuario_id', '')
                ->join(array('r' => 'role'), 'ur.role_id = r.role_id', '');
        if ($idUsuario != '')
            $smt = $smt->where('usuario_id =?', $idUsuario);
        if ($notinRole != '') {
            $smt = $smt->where('usuario_id <> ?', 1);
        }

        $smt = $smt->query();
        if ($idUsuario == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }
    
    /**
     * @param string $idUsuario    
     * @return array        
     */
    
    public function getUsuarioForEmail($idUsuario) {
        $tableUsuario = new Application_Model_DbTable_Usuario();
        $smt = $tableUsuario->getAdapter()->select()
                ->from(array('u' => 'usuario'), array(
                    'u.usuario_id',
                    'u.usuario_identity',
                    'u.usuario_nombres',
                    'u.usuario_apellidos',
                    'u.usuario_email',
                    'u.empresa_id',
                ))
                ->join(array('i' => 'implicado'), 'u.implicado_id = i.implicado_id', '')
                ->where('usuario_id =?', $idUsuario);
        $smt = $smt->query();
        $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @param array $data
     * @return int|boolean
     */
    public function insert($data) {
        if (!is_array($data)) {
            return false;
        }
        $tableUsuario = new Application_Model_DbTable_Usuario();
        try {
            $tableUsuario->insert($data);
            $result = $tableUsuario->getAdapter()->lastInsertId();
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }
    
    /**
     * @param array $data
     * @return int|boolean
     */
    public function insertUsuarioRole($data) {
        if (!is_array($data)) {
            return false;
        }
        $tableUsuarioRole = new Application_Model_DbTable_UsuarioRole();
        try {
            $tableUsuarioRole->insert($data);
            $result = $tableUsuarioRole->getAdapter()->lastInsertId();
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
        $tableUsuario = new Application_Model_DbTable_Usuario();
        try {
            $where = $tableUsuario->getAdapter()->quoteInto('usuario_id =?', $id);
            $result = $tableUsuario->update($data, $where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    /**
     * @param int $id
     * @return int|boolean
     */
    public function delete($id) {
        $tableUsuario = new Application_Model_DbTable_Usuario();
        try {
            $where = $tableUsuario->getAdapter()->quoteInto('usuario_id =?', $id);
            $result = $tableUsuario->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getRoles() {
        $tableRole = new Application_Model_DbTable_Role();
        $smt = $tableRole->getAdapter();
        $smt = $smt->select()->from(array('pm1' => 'role'), array(
                    'role' => 'pm1.role_nombre',
                    'extend' => 'pm2.role_nombre',
                ))
                ->joinLeft(array('pm2' => 'role'), 'pm1.role_extends=pm2.role_id', '')
                ->where('pm1.role_activo=?', 1)
                ->order('pm1.role_id');
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }
    
    /**
     * @param string $usuario
     * @return array
     */
     public function getModuleByUsuario($usuario) {
        $tableUsusario = new Application_Model_DbTable_Usuario();
        $smt = $tableUsusario->getAdapter();
        $smt = $smt->select()->from(array('u' => 'usuario'), array(
                    'role' => 'r.role_nombre',
                    'module' => 'r.role_module',
                ))
                ->join(array('ur' => 'usuario_role'), 'ur.usuario_id = u.usuario_id', '')
                ->join(array('r' => 'role'), 'r.role_id = ur.role_id', '')
                ->where('u.usuario_identity = ?', $usuario);
        $smt = $smt->query();
        $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @return array
     */
    public function getPermissions() {
        $tablePermissions = new Application_Model_DbTable_Permission();
        $smt = $tablePermissions->getAdapter();
        $smt = $smt->select()->from(array('p' => 'permission'), array(
                    'role' => 'ro.role_nombre',
                    'resource' => 're.resource_nombre',
                ))
                ->join(array('ro' => 'role'), 'ro.role_id=p.role_id', '')
                ->join(array('re' => 'resource'), 're.resource_id=p.resource_id', '')
                ->where('ro.role_activo=?', 1);

        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @return array
     */
    public function getResources() {
        $tableResource = new Application_Model_DbTable_Resource();
        $smt = $tableResource->select();
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @param string $email    
     * @param int $excepto
     * @param int $activo
     * @return array        
     */
    public function getByEmail($email, $excepto = 0, $activo = 0) {
        $tableImplicado = new Application_Model_DbTable_Implicado();
        $smt = $tableImplicado->getAdapter();
        $smt = $smt->select()->from(array('u' => 'usuario'), array(
                    'u.usuario_id',
                    'i.implicado_email',
                ))
                ->join(array('i' => 'implicado'), 'u.implicado_id = i.implicado_id', '')
                ->where('i.implicado_email = ?', $email)
                ->where('u.usuario_id <> ?', $excepto);
        if ($activo)
            $smt = $smt->where('u.usuario_flag_activo  = ?', 1);
        $smt = $smt->query();
        $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @param string $login
     * @param int $excepto
     * @return array        
     */
    public function getByLogin($login, $excepto = 0) {
        $tableUsuario = new Application_Model_DbTable_Usuario();
        $smt = $tableUsuario->select()
                ->where('usuario_identity = ?', $login)
                ->where('usuario_id <> ?', $excepto);
        Core_Log::error($smt);
        $smt = $smt->query();
        $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @param string $identity
     * @return array        
     */
    public function authentificate($identity) {
        $tableUsuario = new Application_Model_DbTable_Usuario();
         $sel = $tableUsuario->getAdapter()->select()
                ->from(array('u'=>'usuario'),array(
                    'u.usuario_id',
                    'u.usuario_identity',
                    'u.usuario_password',
                    'u.usuario_hash',
                    'u.swt_activo',
                    'u.usuario_nombre',
                    'u.usuario_apellido',
                    'u.usuario_email',
                    'u.empresa_id',
                    'r.role_nombre',
                    'r.role_id',
                    'r.role_module',
                    'roles' => new Zend_Db_Expr("GROUP_CONCAT(CONCAT(r.role_id,',',r.role_nombre,',',r.role_module) SEPARATOR '|')")
                     ))
                ->join(array('ur' => 'usuario_role'), 'ur.usuario_id = u.usuario_id', '')
                ->join(array('r' => 'role'), 'ur.role_id = r.role_id', '')
                ->where('u.usuario_identity = ?', $identity)
                ->where('u.swt_activo = 1')
                ->where('r.role_activo = 1')
                ->where('r.role_flag_delete = 0');
        $sel = $sel->query();

        $result = $sel->fetch();

        $sel->closeCursor();
        return $result;
    }

    /**
     * @param int $usuario
     * @param string $hash
     * @return array
     */
    public function checkHashPassword($usuario, $hash) {
        $tableUsuario = new Application_Model_DbTable_Usuario();
        $sel = $tableUsuario->select()
                ->from(array('u' => 'usuario'))
                ->where('u.usuario_id = ?', $usuario)
                ->where('u.usuario_hash = ?', $hash);
        $sel = $sel->query();
        $result = $sel->fetch();
        $sel->closeCursor();
        return $result;
    }

    /**
     * @param int $usuario
     * @param string $hash
     * @param string $password
     * @param string $newhash
     * @return bool|int
     */
    public function recuperarContrasena($usuario, $hash, $password, $newhash) {
        $tableUsuario = new Application_Model_DbTable_Usuario();
        $where = array();
        try {
            $where[] = $tableUsuario->getAdapter()->quoteInto('usuario_id = ?', $usuario);
            $where[] = $tableUsuario->getAdapter()->quoteInto('usuario_hash = ?', $hash);
            $result = $tableUsuario->update(array(
                'usuario_password' => $password,
                'usuario_hash' => $newhash,), $where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    /**
     * @param string $email Email del abogado a buscar
     * @return array Informacion del abogado
     * @author Diego Lopez
     */
    public function getUsuarioByEmail($email) {
        $table = new Application_Model_DbTable_Usuario();
        $smt = $table->getAdapter()->select()->from(array('u' => 'usuario'), array(
                    'u.usuario_id'
                ))
                ->join(array('i' => 'implicado'), 'u.implicado_id = i.implicado_id', '')
                ->where('i.implicado_email = ?', $email);
        $smt = $smt->query();
        $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }
    
    /**
     * @param string $n
     * @return array Informacion del abogado
     */
    public function getCorreosAdquisicion($n) {
        $table = new Application_Model_DbTable_Usuario();
        $smt = $table->getAdapter()->select()->from(array('u' => 'usuario'), array(
                    'u.usuario_email'
                ))
                ->join(array('e' => 'empresa'), 'e.empresa_id = u.empresa_id', '')
                ->join(array('ur' => 'usuario_role'), 'ur.usuario_id = u.usuario_id', '')
                ->where('e.categoria_id IN ('.$n.')')
                ->where('ur.role_id = ?',11);
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

}
