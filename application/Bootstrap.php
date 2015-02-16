<?php

use PhSpring\ZF1\Application\Bootstrap as ZF1Bootstrap;
use PhSpring\ZF1\Application\Resource\ServiceLoader;
use PhSpring\ZF1\Controller\Dispatcher;

class Bootstrap extends ZF1Bootstrap {

    public function __construct($application) {
        parent::__construct($application);
        Zend_Controller_Front::getInstance()->setDispatcher(new Dispatcher());
        $this->config = new Zend_Config($this->getOptions());
        Zend_Registry::set('Zend_Config', $this->config);
        Zend_Registry::set('config', $this->config);
        new ServiceLoader($this->getOptions());
    }

}
