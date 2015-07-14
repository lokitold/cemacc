<?php

class Application_Model_Empresa extends Core_Model {

    public function __construct() {
        
    }

    /**
     * @param string $idEmpresa    
     * @return array        
     */
    public function getEmpresa($idEmpresa = '') {
        $tableEmpresa = new Application_Model_DbTable_Empresa();
        $smt = $tableEmpresa->getAdapter()->select()
                ->from(array('e' => 'empresa'), array(
                    'e.empresa_id',
                    'e.empresa_nombre_comercial',
                    'e.empresa_razon_social',
                    'e.empresa_ruc',
                    'e.empresa_website',
                    'e.categoria_id',
                    'e.subcategoria_id',
                    'c.categoria_nombre',
                    's.subcategoria_nombre',
                    'e.empresa_imagen',
                    'e.empresa_logo',
                    'e.swt_activo',
                    'u.ubicacion_id',
                    'u.pais_id',
                    'p.pais_nombre',
                    'u.ubigeo_id',
                    'ub.departamento',
                    'ub.provincia',
                    'ub.distrito',
                    'u.ubicacion_direccion',
                    'ubicacion_swt' => 'u.swt_activo',
                ))
                ->join(array('u' => 'ubicacion'), 'u.empresa_id = e.empresa_id', '')
                ->joinLeft(array('ub' => 'ubigeo'), 'ub.ubigeo_id = u.ubigeo_id', '')
                ->joinLeft(array('p' => 'pais'), 'p.pais_id = u.pais_id', '')
                ->joinLeft(array('c' => 'categoria'), 'c.categoria_id = e.categoria_id', '')
                ->joinLeft(array('s' => 'subcategoria'), 's.subcategoria_id = e.subcategoria_id', '');
        if ($idEmpresa != '')
            $smt = $smt->where('e.empresa_id =?', $idEmpresa);
        $smt = $smt->query();
        if ($idEmpresa == '')
            $result = $smt->fetchAll();
        else
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
        $tableEmpresa = new Application_Model_DbTable_Empresa();
        $tableEmpresaRubro = new Application_Model_DbTable_EmpresaRubro();
        try {
            $tableEmpresa->insert($data);
            $result = $tableEmpresa->getAdapter()->lastInsertId();
            $tableEmpresaRubro->insert(array('empresa_id' => $result, 'rubro_id' => $data['rubro_id']));
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
        $tableEmpresa = new Application_Model_DbTable_Empresa();
        try {
            $where = $tableEmpresa->getAdapter()->quoteInto('empresa_id =?', $id);
            $result = $tableEmpresa->update($data, $where);
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
        $tableEmpresa = new Application_Model_DbTable_Empresa();
        try {
            $where = $tableEmpresa->getAdapter()->quoteInto('empresa_id =?', $id);
            $result = $tableEmpresa->delete($where);
        } catch (Exception $exc) {
            Core_Log::error($exc->__toString());
            $result = false;
        }
        return $result;
    }

    public function getLogosEmpresa() {
        $tableEmpresa = new Application_Model_DbTable_Empresa();
        $smt = $tableEmpresa->getAdapter()->select()
                ->from(array('e' => 'empresa'), array(
                    'e.empresa_id',
                    'e.empresa_nombre_comercial',
                    'e.empresa_logo',
                ))
                ->where('e.empresa_logo !=?', "")
                ->where('e.swt_activo =?', 1);
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

    /**
     * @param int $idCategoria    
     * @return array        
     */
    public function getEmpresaByCategoria($idCategoria) {
        $tableEmpresa = new Application_Model_DbTable_Empresa();
        $smt = $tableEmpresa->getAdapter()->select()
                ->from(array('e' => 'empresa'), array(
                    'e.empresa_id',
                    'e.empresa_nombre_comercial',
                    'e.empresa_razon_social',
                    'e.empresa_ruc',
                    'e.categoria_id',
                    'e.subcategoria_id',
                    'e.empresa_imagen',
                    'e.empresa_logo',
                    'e.empresa_website',
                    'e.swt_activo',
                    'u.ubicacion_id',
                    'u.pais_id',
                    'u.ubigeo_id',
                    'ub.departamento',
                    'ub.provincia',
                    'ub.distrito',
                    'c.categoria_nombre',
                    's.subcategoria_nombre',
                    'u.ubicacion_direccion',
                    'ubicacion_swt' => 'u.swt_activo',
                ))
                ->join(array('u' => 'ubicacion'), 'u.empresa_id = e.empresa_id', '')
                ->joinLeft(array('ub' => 'ubigeo'), 'ub.ubigeo_id = u.ubigeo_id', '')
                ->join(array('c' => 'categoria'), 'c.categoria_id = e.categoria_id', '')
                ->join(array('s' => 'subcategoria'), 's.subcategoria_id = e.subcategoria_id', '')
                ->where('e.categoria_id = ?', $idCategoria)
                ->where('e.swt_activo = ?', 1);
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

    public function autocompleteEmpresas($val) {
        $tableEmpresa = new Application_Model_DbTable_Empresa();
        $smt = $tableEmpresa->getAdapter()->select()
                ->from(array('i' => 'empresa'), array(
                    'label' => 'i.empresa_razon_social',
                    'i.*',
                    'u.*',
                    'ub.*'
                ))
                ->joinLeft(array('u' => 'ubicacion'), 'u.empresa_id = i.empresa_id')
                ->joinLeft(array('ub' => 'ubigeo'), 'ub.ubigeo_id = u.ubigeo_id', '')
                ->where('i.empresa_razon_social like ?', $val);
        $smt = $smt->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

}
