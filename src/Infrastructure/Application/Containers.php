<?php

namespace Dykyi\Infrastructure\Application;

use Dotenv\Dotenv;
use Dykyi\Domain\Command\Analyze;
use Dykyi\Domain\Handler\AnalyzeCommandHandler;
use Dykyi\Infrastructure\Service\Config;
use Interop\Container\ContainerInterface;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use SimpleBus\Command\Bus\CommandBus;
use SimpleBus\Message\Bus\MessageBus;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Containers
 * @package Building\Infrastructure\Service
 */
class Containers
{
    public static function init()
    {
        return new ServiceManager([
            'factories' => [
                Config::class => function (): Config{
                    $envConfig = (new Dotenv(__DIR__ . '/../../../'))->load();
                    return (new Config())->parse($envConfig);
                },

                CommandBus::class => function (): MessageBus {

                    $bus = new MessageBusSupportingMiddleware();
                    $bus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());
                    $commandHandlerMap = new CallableMap(
                        [
                            Analyze::class => AnalyzeCommandHandler::class,
                        ],
                        new ServiceLocatorAwareCallableResolver(function ($serviceId) {
                            $handler = new $serviceId();
                            //TODO: some logic here
                            return $handler;
                        })
                    );
                    $commandHandlerResolver = new NameBasedMessageHandlerResolver(
                        new ClassBasedNameResolver(), $commandHandlerMap
                    );
                    $bus->appendMiddleware(new DelegatesToMessageHandlerMiddleware($commandHandlerResolver));

                    return $bus;
                },

                EventDispatcher::class => function (): EventDispatcher {
                    return new EventDispatcher();
                },

                'Whoops' => function (){
                    $whoops = new \Whoops\Run;
                    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
                    $whoops->register();
                },

                Logger::class => function (ContainerInterface $container) {
                    $config = $container->get(Config::class);

                    $logger = new Logger('app');
                    $logger->pushHandler(new StreamHandler(__DIR__ . $config->get('app.log_path'), Logger::DEBUG));
                    $logger->pushHandler(new FirePHPHandler());

                    return $logger;
                },
            ]
        ]);
    }
}