<?php

namespace Dykyi\Application\Transformer;

use Dykyi\Domain\ValueObjects\CliInput;
use SimpleBus\Command\Command;

/**
 * Interface ConvertStringToCommandInterface
 * @package Dykyi\Application\Transformer
 */
interface ConvertStringToCommandInterface
{
    /**
     * @param CliInput $command
     * @return Command
     */
    public function convert(CliInput $command): Command;
}