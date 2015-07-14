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
class Core_ProfilerLog {
    //put your code here
   static function log($data) {
       $loger = new Zend_Log();
       $writer = new Zend_Log_Writer_Firebug();
       $loger->addWriter($writer);
       $loger->log(print_r($data,true), Zend_Log::INFO);
   }

}

?>
