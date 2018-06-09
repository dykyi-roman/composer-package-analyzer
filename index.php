<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/vendor/autoload.php';

use Dykyi\Infrastructure\Application\Command\AnalyzeCommand;
use Dykyi\Infrastructure\Application\Command\ShowCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new ShowCommand());
$application->add(new AnalyzeCommand());
$application->run();