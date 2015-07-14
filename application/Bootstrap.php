<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    public function __construct($app) {
        date_default_timezone_set('America/Lima');
        parent::__construct($app);
        $app = $this->getOption('app');
        //print_r($this->getResourceLoader());
        $this->getResourceLoader()->addResourceType('entity', 'entitys/', 'Entity');
        defined('STATIC_URL') || define('STATIC_URL', $app['staticUrl']);
        defined('DINAMIC_URL') || define('DINAMIC_URL', $app['dinamicUrl']);
        defined('BASE_URL') || define('BASE_URL', $app['siteUrl']);

        defined('REPORT_URL') || define('REPORT_URL', $app['reportServerUrl']);
        defined('REPORT_PORT') || define('REPORT_PORT', $app['reportServerPort']);
        defined('REPORT_USER') || define('REPORT_USER', $app['reportServerUser']);
        defined('REPORT_PASSWORD') || define('REPORT_PASSWORD', $app['reportServerPassword']);
        defined('REPORT_LOCATION') || define('REPORT_LOCATION', $app['reportServerLocation']);

        $this->bootstrap('cachemanager');
        $cache = $this->getResource('cachemanager')->getCache('file');
        Zend_Registry::set('cache', $cache);
        
        Zend_Registry::set('db',$this->getResource('db'));
        
        $email = $this->getOption('email');
        defined('FRONT_MAIL_DEFAULT') || define('FRONT_MAIL_DEFAULT', $email['front']);
        $emailConfig = array(
            'auth' => 'login',
            'username' => $email['username'],
            'password' => $email['password'],
            'port' => $email['port'],
                //'ssl' => $email['protocol']
        );
        $mailTransport = new Zend_Mail_Transport_Smtp($email['server'], $emailConfig);
        Zend_Mail::setDefaultTransport($mailTransport);
        //$this->setdbSession();
    }

    public function _initTranslate() {
        $translator = new Zend_Translate(
                Zend_Translate::AN_ARRAY, APPLICATION_PATH . '/configs/languages/', 'es', array('scan' => Zend_Translate::LOCALE_DIRECTORY)
        );

        Zend_Validate_Abstract::setDefaultTranslator($translator);
    }

}

