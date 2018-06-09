<?php

namespace Dykyi\Infrastructure\Application\Command;

use SimpleBus\Command\Bus\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Dykyi\Domain\Command\Analyze;
use Dykyi\Infrastructure\Application\Containers;
use Dykyi\Application\Service\Infrastructure\ComposerLockParser\ComposerInfo;

/**
 * Class ShowCommand
 * @package Dykyi\Infrastructure\Application\Command
 */
class AnalyzeCommand extends Command
{
    protected function configure()
    {
        $this->setName('analyze')
            ->setDescription('Analyze package for save update')
            ->setHelp('This command analyze all packages in composer.lock for save update')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to composer.lock file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $composerInfo = new ComposerInfo($input->getArgument('path') . '/composer.lock');
        $composerInfo->parse();

        $sm = Containers::init();
        /** @var CommandBus $bus */
        $bus = $sm->get(CommandBus::class);
        $bus->handle(new Analyze($composerInfo->getPackages()));
    }
}