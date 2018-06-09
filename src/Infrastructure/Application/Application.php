<?php

namespace Dykyi\Application;

use Dykyi\Domain\ValueObjects\CliInput;
use Dykyi\Exception\CommandNotFoundException;
use Dykyi\Infrastructure\Application\Transformer\ConvertStringToCommand;
use Rhumsaa\Uuid\Console\Exception;
use SimpleBus\Command\Bus\CommandBus;
use Symfony\Component\HttpFoundation\Response;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Application
 * @package Dykyi\Application
 */
class Application
{
    /**
     * @var ServiceManager
     */
    private $serviceManager;

    /**
     * Application constructor.
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @param array $argv
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function run(array $argv): Response
    {
        try {
            $command = (new ConvertStringToCommand)->convert(new CliInput($argv));
            $command->setServiceManager($this->serviceManager);

            /** @var CommandBus $commandBus */
            $commandBus = $this->serviceManager->get(CommandBus::class);
            $commandBus->handle($command);
        } catch (CommandNotFoundException $exception) {
            return Response::create($exception->getMessage());
        } catch (Exception $exception) {
            return Response::create(sprintf('Undefined Exception: %s',$exception->getMessage()));
        }
    }
}

