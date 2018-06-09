<?php

namespace Dykyi\Infrastructure\Application\Transformer;

use Dykyi\Application\Transformer\ConvertStringToCommandInterface;
use Dykyi\Domain\ValueObjects\CliInput;
use Dykyi\Exception\CommandNotFoundException;
use SimpleBus\Command\Command;

class ConvertStringToCommand implements ConvertStringToCommandInterface
{
    /**
     * @param CliInput|string $command
     * @return Command
     * @throws CommandNotFoundException
     */
    public function convert(CliInput $command): Command
    {
        $commandClass = "Dykyi\\Domain\\Command\\" . ucfirst($command->getCommand());
        if (!class_exists($commandClass))
        {
            throw new CommandNotFoundException(sprintf('Command %s not found', $command));
        }

        return new $commandClass(...$command->getOptions());
    }
}