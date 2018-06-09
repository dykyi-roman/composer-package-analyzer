<?php

namespace Building\App;

use Dykyi\Application\Application;
use Dykyi\Application\Service\ConfigInterface;
use Dykyi\Infrastructure\Application\Containers;
use Zend\ServiceManager\ServiceManager;

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/vendor/autoload.php';

/** @var ServiceManager $sm */
$sm = Containers::init();

if ($sm->get(ConfigInterface::class)->get('app.debug')) {
    $sm->get('Whoops');
}

$app = new Application($sm);
$response = $app->run($argv);
$response->send();