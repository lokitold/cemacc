<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CST_Auth_Storage_Session
 *
 * @author Laptop
 */
class CST_Auth_Storage_Session extends Zend_Auth_Storage_Session {
    const NAMESPACE_DEFAULT = 'CST_Auth';

    /**
     * Default session object member name
     */
    const MEMBER_DEFAULT = 'storage';

    /**
     * Object to proxy $_SESSION storage
     *
     * @var Zend_Session_Namespace
     */
    protected $_session;

    /**
     * Session namespace
     *
     * @var mixed
     */
    protected $_namespace;

    /**
     * Session object member
     *
     * @var mixed
     */
    protected $_member;
    
    public function __construct($namespace = self::NAMESPACE_DEFAULT, $member = self::MEMBER_DEFAULT)
    {
        $this->_namespace = $namespace;
        $this->_member    = $member;
        $this->_session   = new Zend_Session_Namespace($this->_namespace);
    }
}

?>
