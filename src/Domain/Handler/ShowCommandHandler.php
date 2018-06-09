<?php

namespace Dykyi\Domain\Handler;

use Dykyi\Application\Service\Infrastructure\ComposerLockParser\ComposerInfo;
use Dykyi\Domain\Command\Show;
use Symfony\Component\HttpFoundation\Response;

class ShowCommandHandler
{
    public function handle(Show $command)
    {
        $composerInfo = new ComposerInfo($command->getPath() . '/composer.lock');
        $composerInfo->parse();

        $packages = $composerInfo->getPackages();
        $responseText = '';
        foreach ($packages as $package){
             $responseText .= $package->getName() . ' :: ' . $package->getVersion().  "\n";
        }

        Response::create($responseText)->send();
    }
}