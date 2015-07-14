<?php
class Core_Jasper_InputStructure {

    public $id;
    public $type;
    public $uri;
    public $label;
    public $mandatory;
    public $readOnly;
    public $visible;
    public $masterDependencies = array();
    public $slaveDependencies = array();
    public $validationRules = array();
    public $inputOptions = array();

    public function __construct($uri = null, $id = null, $type = null, $label = null, 
                                $mandatory = null, $readOnly = null, $visible = null) {
        $this->uri = (!empty($uri)) ? strval($uri) : null;
        $this->id = (!empty($id)) ? strval($id) : null;
        $this->type = (!empty($type)) ? strval($type) : null;
        $this->label = (!empty($label)) ? strval($label) : null;
        $this->mandatory = (!empty($mandatory)) ? $mandatory : null;
        $this->readOnly = (!empty($readOnly)) ? $readOnly : null;
        $this->visible = (!empty($visible)) ? $visible : null;
    }

    public static function createFromJSON($json) {
        $data_array = json_decode($json, true);
        $result = array();
        foreach($data_array['inputControl'] as $k) {
            $temp = new self($k['uri'], $k['id'], $k['type'], $k['label'], $k['mandatory'], $k['readOnly'],
                             $k['visible']);
            if (!empty($k['state'])) {
                    $temp->inputOptions = Core_Jasper_InputOptions::createFromArray($k['state']);
            }
            if (isset($k['masterDependecies'])) {
                $temp->masterDependencies = $k['masterDependecies'];
            }
            if (isset($k['slaveDependencies'])) {
                $temp->slaveDependencies = $k['slaveDependencies'];
            }
            if (isset($k['validationRules'])) {
            $temp->validationRules = $k['validationRules'];
            }
            $result[] = $temp;
        }
        return $result;
    }


    public function getInputOptions() {
        return $this->inputOptions;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getLabel() {
        return $this->label;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function getId() {
        return $this->id;
    }

}