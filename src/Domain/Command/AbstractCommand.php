<?php

namespace Dykyi\Domain\Command;

use Zend\ServiceManager\ServiceManager;

/**
 * Class AbstractCommand
 * @package Dykyi\Domain\Command
 */
abstract class AbstractCommand
{
    private $serviceManager;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getServiceManager(): ServiceManager
    {
        return $this->serviceManager;
    }
}
