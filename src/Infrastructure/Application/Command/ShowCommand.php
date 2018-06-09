<?php

namespace Dykyi\Infrastructure\Application\Command;

use Dykyi\Application\Service\Infrastructure\ComposerLockParser\ComposerInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ShowCommand
 * @package Dykyi\Infrastructure\Application\Command
 */
class ShowCommand extends Command
{
    protected function configure()
    {
        $this->setName('show-packages')
            ->setDescription('Show all packages.')
            ->setHelp('This command show all packages in composer.lock file')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to composer.lock file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $composerInfo = new ComposerInfo($input->getArgument('path') . '/composer.lock');
        $composerInfo->parse();

        $packages = $composerInfo->getPackages();
        $responseText = '';
        foreach ($packages as $package){
            $responseText .= $package->getName() . ' :: ' . $package->getVersion().  "\n";
        }

        $output->writeln($responseText);
    }
}