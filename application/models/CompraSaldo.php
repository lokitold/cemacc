<?php

class Application_Model_CompraSaldo extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idCompraSaldo
     * @return array $data       
     */
    public function getCompraSaldo($idCompraSaldo = '') {
        $tableCompraSaldo = new Application_Model_DbTable_CompraSaldo();
        $smt = $tableCompraSaldo->getAdapter()->select()
                ->from(array('cs' => 'compra_saldo'), array(
                    'cs.compra_saldo_id',
                    'e.empresa_nombre_comercial',
                    'p.paquete_nombre',
                    'p.paquete_precio',
                    'cs.fecha_compra',
                    'cs.fecha_confirmacion',
                    'cs.swt_activo' 
                ))
                ->join(array('e' => 'empresa'), 'e.empresa_id = cs.empresa_id', '')
                ->join(array('p' => 'paquete'), 'p.paquete_id = cs.paquete_id', '');
        if ($idCompraSaldo != '')
            $smt = $smt->where('compra_saldo_id =?', $idCompraSaldo);
        $smt = $smt->query();
        if ($idCompraSaldo == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
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
        $tableCompraSaldo = new Application_Model_DbTable_CompraSaldo();
        try {
            $where = $tableCompraSaldo->getAdapter()->quoteInto('compra_saldo_id =?', $id);
            $result = $tableCompraSaldo->update($data, $where);
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
    public function insert($data) {
        if (!is_array($data)) {
            return false;
        }
        $tableCompraSaldo = new Application_Model_DbTable_CompraSaldo();
        try {
            $tableCompraSaldo->insert($data);
            $result = $tableCompraSaldo->getAdapter()->lastInsertId();
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
