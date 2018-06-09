<?php

namespace Dykyi\Domain\Command;

use Dykyi\Domain\Aggregate\PackagesCollection;
use SimpleBus\Command\Command;

/**
 * Class Analyze
 * @package Dykyi\Domain\Command
 */
final class Analyze  implements Command
{
    /** @var  PackagesCollection */
    private $packages;

    public function __construct(PackagesCollection $packages)
    {
        $this->packages = $packages;
    }

    public function name(): string
    {
        return __CLASS__;
    }

    public function getPackages(): PackagesCollection
    {
        return $this->packages;
    }
}
