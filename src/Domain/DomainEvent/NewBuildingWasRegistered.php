<?php

namespace Dykyi\Domain\DomainEvent;

final class NewBuildingWasRegistered
{
    public const NAME = 'TEST';

    public function name() : string
    {
        return self::NAME;
    }
}
