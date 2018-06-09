<?php

namespace Dykyi\Domain\Command;

use SimpleBus\Command\Command;

/**
 * Class Show
 * @package Dykyi\Domain\Command
 */
final class Show extends AbstractCommand  implements Command
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function name(): string
    {
        return __CLASS__;
    }

    public function getPath()
    {
        return $this->path;
    }
}
