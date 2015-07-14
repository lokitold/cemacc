<?php

class Application_Model_Capacitacion extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idCapacitacion
     * @return array $data       
     */
    public function getCapacitacion($idCapacitacion = '') {
        $tableCapacitacion = new Application_Model_DbTable_Capacitacion();
        $smt = $tableCapacitacion->getAdapter()->select()
                ->from(array('c' => 'capacitacion'), array(
                    'c.capacitacion_id',
                    'c.capacitacion_titulo',
                    'c.capacitacion_imagen',
                    'c.capacitacion_fecha_registro',
                    'c.capacitacion_presentacion',
                    'c.capacitacion_beneficios',
                    'c.capacitacion_contenido',
                    'c.capacitacion_info_general',
                    'c.capacitacion_fecha',
                    'c.capacitacion_asiste',
                    'c.swt_activo',
                    't.trainer_id',
                    't.trainer_nombres',
                    't.trainer_apellidos',
                    't.trainer_descripcion',
                    't.trainer_foto',
                ))
                ->join(array('t' => 'trainer'), 'c.trainer_id = t.trainer_id', '');
        if ($idCapacitacion != '')
            $smt = $smt->where('capacitacion_id =?', $idCapacitacion);
        $smt = $smt->query();
        if ($idCapacitacion == '')
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
    public function getAdquisicionByEmpresa($idEmpresa) {
        $tableAdquisicion = new Application_Model_DbTable_Adquisicion();
        $smt = $tableAdquisicion->select()
                ->where('empresa_id =?', $idEmpresa);
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
        $tableCapacitacion = new Application_Model_DbTable_Capacitacion();
        try {
            $tableCapacitacion->insert($data);
            $result = $tableCapacitacion->getAdapter()->lastInsertId();
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
        $tableCapacitacion = new Application_Model_DbTable_Capacitacion();
        try {
            $where = $tableCapacitacion->getAdapter()->quoteInto('capacitacion_id =?', $id);
            $result = $tableCapacitacion->update($data, $where);
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
        $tableAdquisicion = new Application_Model_DbTable_Adquisicion();
        try {
            $where = $tableAdquisicion->getAdapter()->quoteInto('adquisicion_id =?', $id);
            $result = $tableAdquisicion->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

}
