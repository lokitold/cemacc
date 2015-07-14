<?php

class Core_Auth_Adapter_ServiceDb implements Zend_Auth_Adapter_Interface {

    protected $_credentialColumn = 'usuario_password';
    public $_authenticateResultInfo = null;
    protected $_resultRow = null;
    private $_rol = null;
    private $_serviceModel = null;
    
    
    public function __construct() {
        $this->_serviceModel = 'Usuario';
    }
    public function authenticate() {
        $this->_authenticateSetup();
        $objServiceDb = Core_Entity::setService($this->_serviceModel);
        $row = $objServiceDb->authentificate($this->_identity);  
        
        
        
        $row['zend_auth_credential_match'] = 0;
        if (!empty($row)) {
            $encPass = $row[$this->_credentialColumn];
            
            if (self::checkPassword($this->_credential, $encPass)) {
                $row['zend_auth_credential_match'] = 1;
            }
        }
        return $this->_authenticateValidateResult($row);
    }

    protected function _authenticateValidateResult($resultIdentity) {
        $zendAuthCredentialMatchColumn = 'zend_auth_credential_match';
        
        if ($resultIdentity[$zendAuthCredentialMatchColumn] != '1') {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $this->_authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            return $this->_authenticateCreateAuthResult();
        }

        unset($resultIdentity[$zendAuthCredentialMatchColumn]);
        $this->_resultRow = $resultIdentity;

        $this->_authenticateResultInfo['code'] = Zend_Auth_Result::SUCCESS;
        $this->_authenticateResultInfo['messages'][] = 'Authentication successful.';
        return $this->_authenticateCreateAuthResult();
    }

    /**
     * Genera contraseña
     *
     * @param string $rawPassword
     * @param string $algo Algoritmo usado para generar la contraseña. md5, sha1
     * @return string
     */
    public static function generatePassword($rawPassword, $algo='sha1') {
        $salt = substr(md5(rand(0, 999999) + time()), 6, 5);
        $passw = '';

        if ($algo == 'sha1') {
            $passw = $algo . '$' . $salt . '$' . sha1($salt . $rawPassword);
        } else {
            $passw = $algo . '$' . $salt . '$' . md5($salt . $rawPassword);
        }
        return $passw;
    }

    /**
     * Retorna true si el password es correcto
     *
     * @param string $rawPassword
     * @param string $encPassword
     * @return bool
     */
    public static function checkPassword($rawPassword, $encPassword) {
        $parts = explode('$', $encPassword);
        if (count($parts) != 3) {
            return false;
        }

        $algo = strtolower($parts[0]);
        $salt = $parts[1];
        $encPass = $parts[2];

        $credentialEnc = '';
        if ($algo == 'sha1') {
            $credentialEnc = sha1($salt . $rawPassword, false);
        } else {
            $credentialEnc = md5($salt . $rawPassword, false);
        }
        
        return $credentialEnc == $encPass;
    }

    public function setRol($rol) {
        $this->_rol = $rol;
        return $this;
    }

    protected function _authenticateSetup() {
        $exception = null;
        if ($this->_identity == '') {
            $exception = 'A value for the identity was not provided prior to authentication with Zend_Auth_Adapter_DbTable.';
        } elseif ($this->_credential === null) {
            $exception = 'A credential value was not provided prior to authentication with Zend_Auth_Adapter_DbTable.';
        }

        if (null !== $exception) {
            /**
             * @see Zend_Auth_Adapter_Exception
             */
            require_once 'Zend/Auth/Adapter/Exception.php';
            throw new Zend_Auth_Adapter_Exception($exception);
        }

        $this->_authenticateResultInfo = array(
            'code' => Zend_Auth_Result::FAILURE,
            'identity' => $this->_identity,
            'messages' => array()
        );

        return true;
    }

    protected function _authenticateCreateAuthResult() {
        return new Zend_Auth_Result(
                        $this->_authenticateResultInfo['code'],
                        $this->_authenticateResultInfo['identity'],
                        $this->_authenticateResultInfo['messages']
        );
    }

    public function setIdentity($value) {
        $this->_identity = $value;
        return $this;
    }

    public function setCredential($credential) {
        $this->_credential = $credential;
        return $this;
    }

    public function getResultRowObject($returnColumns = null, $omitColumns = null) {
        if (!$this->_resultRow) {
            return false;
        }

        $returnObject = new stdClass();

        if (null !== $returnColumns) {

            $availableColumns = array_keys($this->_resultRow);
            foreach ((array) $returnColumns as $returnColumn) {
                if (in_array($returnColumn, $availableColumns)) {
                    $returnObject->{$returnColumn} = $this->_resultRow[$returnColumn];
                }
            }
            return $returnObject;
        } elseif (null !== $omitColumns) {

            $omitColumns = (array) $omitColumns;
            foreach ($this->_resultRow as $resultColumn => $resultValue) {
                if (!in_array($resultColumn, $omitColumns)) {
                    $returnObject->{$resultColumn} = $resultValue;
                }
            }
            return $returnObject;
        } else {

            foreach ($this->_resultRow as $resultColumn => $resultValue) {
                $returnObject->{$resultColumn} = $resultValue;
            }
            return $returnObject;
        }
    }
    
    public function getCode(){
        return $this->_authenticateResultInfo['code'];
    }

}