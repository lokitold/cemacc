<?php

class Application_Entity_Publicacion extends Core_Entity {

    protected $_id;
    protected $_nombre;
    protected $_descripcion;
    protected $_categoriaId;
    protected $_subcategoriaId;
    protected $_precio;
    protected $_cantidad;
    protected $_imagen;
    protected $_fechaInicio;
    protected $_fechaFin;
    protected $_empresaId;
    protected $_paqueteId;
    protected $_usuarioId;
    protected $_posicion;
    protected $_flagActivo;

    public function identify($id) {
        $service = $this->setService('Publicacion');
        $data = $service->getPublicacion($id);
        $this->setPropertiesDataBase($data);
        return $data;
    }

    private function setPropertiesDataBase($data) {
        $this->_id = $data['publicacion_id'];
        $this->_nombre = $data['publicacion_nombre'];
        $this->_descripcion = $data['publicacion_descripcion'];
        $this->_categoriaId = $data['categoria_id'];
        $this->_subcategoriaId = $data['subcategoria_id'];
        $this->_precio = $data['publicacion_precio'];
        $this->_cantidad = $data['publicacion_cantidad'];
        $this->_imagen = $data['publicacion_imagen'];
        $this->_fechaInicio = $data['publicacion_fecha_inicio'];
        $this->_fechaFin = $data['publicacion_fecha_fin'];
        $this->_empresaId = $data['paquete_id'];
        $this->_paqueteId = $data['empresa_id'];
        $this->_usuarioId = $data['usuario_id'];
        $this->_posicion = $data['publicacion_posicion'];
        $this->_flagActivo = $data['swt_activo'];
    }

    private function setDataBaseProperties() {
        $data = array(
            'publicacion_id' => $this->_id,
            'publicacion_nombre' => $this->_nombre,
            'publicacion_descripcion' => $this->_descripcion,
            'categoria_id' => $this->_categoriaId,
            'subcategoria_id' => $this->_subcategoriaId,
            'publicacion_precio' => $this->_precio,
            'publicacion_cantidad' => $this->_cantidad,
            'publicacion_imagen' => $this->_imagen,
            'publicacion_fecha_inicio' => $this->_fechaInicio,
            'publicacion_fecha_fin' => $this->_fechaFin,
            'empresa_id' => $this->_empresaId,
            'paquete_id' => $this->_paqueteId,
            'usuario_id' => $this->_usuarioId,
            'publicacion_posicion' => $this->_posicion,
            'swt_activo' => $this->_flagActivo,
        );
        return $this->cleanArray($data);
    }

    public function insert() {
        $service = self::setService('Publicacion');
        $fechaInicio = new Zend_Date($this->_fechaInicio);
        $this->_fechaInicio = $fechaInicio->get('YYYY-MM-dd HH:mm:ss');
        $fechaFin = new Zend_Date($this->_fechaFin);
        $this->_fechaFin = $fechaFin->get('YYYY-MM-dd HH:mm:ss');
        $this->_id = $service->insert($this->setDataBaseProperties());
        return $this->_id;
    }

    public function update() {
        $service = self::setService('Publicacion');
        return $service->update($this->_id, $this->setDataBaseProperties());
    }

    static function delete($id) {
        $service = self::setService('Publicacion');
        return $service->delete($id);
    }

    static function getAllPublicacion() {
        $service = new Application_Model_Publicacion();
        return $service->getPublicacion();
    }
    
    static function activar($id,$estado){
        $service = self::setService('Juzgado');
        $data = array(
            'juzgado_flag_activo' => $estado,
        );
        return $service->update($id,$data);
    }
    
    static function getPublicacionHome($posicion) {
        $service = new Application_Model_Publicacion();
        return $service->getPublicacionHome($posicion);
    }
    
    static function getPublicacionByEmpresa($empresa) {
        $service = new Application_Model_Publicacion();
        return $service->getPublicacionByEmpresa($empresa);
    }

}