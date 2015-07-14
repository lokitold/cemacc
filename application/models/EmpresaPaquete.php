<?php

class Application_Model_EmpresaPaquete extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idEmpresaPaquete
     * @return array $data       
     */
    public function getEmpresaPaquete($idEmpresaPaquete = '') {
        $tableEmpresaPaquete = new Application_Model_DbTable_EmpresaPaquete();
        $smt = $tableEmpresaPaquete->select();
        if ($idEmpresaPaquete != '')
            $smt = $smt->where('paquete_id =?', $idEmpresaPaquete);
        $smt = $smt->query();
        if ($idEmpresaPaquete == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }
    
    /**
     * @param string $idEmpresa
     * @return array $data       
     */
    public function getEmpresaPaqueteByEmpresa($idEmpresa) {
        $tableEmpresaPaquete = new Application_Model_DbTable_EmpresaPaquete();
        $smt = $tableEmpresaPaquete->getAdapter()->select()
                ->from(array('ep' => 'empresa_paquete'), array(
                    'ep.empresa_paquete_id',
                    'ep.empresa_id',
                    'ep.paquete_id',
                    'ep.dias_saldo',
                    'p.paquete_nombre',
                ))
                ->join(array('p' => 'paquete'), 'p.paquete_id = ep.paquete_id', '')
                ->where('ep.empresa_id =?', $idEmpresa);
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @param int $posicion
     * @return array $data       
     */
    public function getPublicacionHome($posicion) {
        $tablePublicacion = new Application_Model_DbTable_Publicacion();
        $smt = $tablePublicacion->select()
                ->where('publicacion_posicion = ?', $posicion)
                ->where('curdate() >= publicacion_fecha_inicio')
                ->where('curdate() <= publicacion_fecha_fin');
        $smt = $smt->query();
        $result = $smt->fetchAll();
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
        $tablePublicacion = new Application_Model_DbTable_Publicacion();
        try {
            $tablePublicacion->insert($data);
            $result = $tablePublicacion->getAdapter()->lastInsertId();
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
        $tablePublicacion = new Application_Model_DbTable_Publicacion();
        try {
            $where = $tablePublicacion->getAdapter()->quoteInto('publicacion_id =?', $id);
            $result = $tablePublicacion->update($data, $where);
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
        $tablePublicacion = new Application_Model_DbTable_Publicacion();
        try {
            $where = $tablePublicacion->getAdapter()->quoteInto('publicacion_id =?', $id);
            $result = $tablePublicacion->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

}
