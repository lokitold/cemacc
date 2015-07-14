<?php
class Default_CacheController extends Zend_Controller_Action
{
    public function init() {
        parent::init();
    }
    public function indexAction()
    {
        $cache = Zend_Registry::get('cache');
        $cache->clean();
        echo 'cache eliminada';
        exit;
    }
}

