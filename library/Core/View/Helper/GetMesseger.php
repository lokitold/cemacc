<?php

/**
 * S view Helpers is a Loader for Static files
 * providing ability to read prefix from config 
 * and suffix a versioning query string 
 *
 * @author eanaya
 */
class Core_View_Helper_GetMesseger extends Zend_View_Helper_Abstract {

    /**
     * @param  String
     * @return string
     */
    public function getMesseger() {
        $message = new Core_Controller_Action_Helper_FlashMessengerCustom();
        $array = $message->getMessages();
        $arrayClass = array(
            'info' => array('alert-info','Información ! '),//celeste
            'success' => array('alert-success','Éxito ! '),// verde
            'warning' => array('alert-warning','Advertencia ! '),// naranja
            'error' => array('alert-danger','Error ! ')); //rojo
        if (count($array) > 0) {
            foreach ($array as $index) {
                echo'<div class="alert ' . $arrayClass[$index->level][0] . '">';
                echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                echo '<strong>'.$arrayClass[$index->level][1].'</strong>'.$index->message ;
                echo'</div>';
            }
        }
    }

}