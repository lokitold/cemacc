<?php

class Core_Filter_Array {

    private $id;

    function __construct($id) {
        $this->id = $id;
    }

    function isEqualProveedor($key) {
        return $key['proveedor_id'] == $this->id;
    }

}
