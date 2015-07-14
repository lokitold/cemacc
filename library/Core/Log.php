<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Log
 *
 * @author Laptop
 */
class Core_Log {
    //put your code here
    public $_logger;
    const TYPE_CRON ='cron';
    public function __construct() {
        $this->_logger =  $this->getLogger();
    }
    public function getLogger(){
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH .'/../log/application.log');
        return new Zend_Log($writer);
    }
    public function getLoggerCron(){
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH .'/cron/cronlog.log');
        return new Zend_Log($writer);
    }
    static function info($value,$typeLog=''){
        if ( $typeLog=='cron' ) {
            self::getLoggerCron()->info($value);
        } else {
            self::getLogger()->info($value);
        }
    }
    static function error($value,$typeLog=''){
        if ( $typeLog=='cron' ) {
            self::getLoggerCron()->err($value);
        } else {
            self::getLogger()->err($value);
        }
    }
    static function warn($value,$typeLog=''){
        if ( $typeLog=='cron' ) {
            self::getLoggerCron()->warn($value);
        } else {
            self::getLogger()->warn($value);
        }
    }

}

?>
