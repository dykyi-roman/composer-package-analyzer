<?php

namespace Dykyi\Domain\Handler;

use Dykyi\Domain\Command\Analyze;

/**
 * Class AnalyzeCommandHandler
 * @package Dykyi\Domain\Handler
 */
class AnalyzeCommandHandler
{
    public function handle(Analyze $command)
    {
      dump($command->name()); die();
    }
}