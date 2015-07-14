<?php

class Application_Model_Trainer extends Core_Model {

    public function __construct() {
        
    }

    public function getTrainer($idTrainer = '') {
        $tableTrainer = new Application_Model_DbTable_Trainer();
        $smt = $tableTrainer->select();
        if ($idTrainer != '')
            $smt = $smt->where('trainer_id =?', $idTrainer);
        $smt = $smt->query();
        if ($idTrainer == '')
            $result = $smt->fetchAll();
        else
            $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }

    public function getTrainerActivos() {
        $tableTrainer = new Application_Model_DbTable_Trainer();
        $smt = $tableTrainer->select()
                ->where('swt_activo = 1');
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

    public function insert($data) {
        if (!is_array($data)) {
            return false;
        }
        $tableTrainer = new Application_Model_DbTable_Trainer();
        try {
            $tableTrainer->insert($data);
            $result = $tableTrainer->getAdapter()->lastInsertId();
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    public function update($id, $data) {
        if (!is_array($data)) {
            return false;
        }
        $tableTrainer = new Application_Model_DbTable_Trainer();
        try {
            $where = $tableTrainer->getAdapter()->quoteInto('trainer_id =?', $id);
            $result = $tableTrainer->update($data, $where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    public function delete($id) {
        $tableTrainer = new Application_Model_DbTable_Trainer();
        try {
            $where = $tableTrainer->getAdapter()->quoteInto('trainer_id =?', $id);
            $result = $tableTrainer->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

}
