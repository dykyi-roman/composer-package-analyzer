<?php

namespace Dykyi\Application\Service;

use Dykyi\Infrastructure\Service\Config;

/**
 * Interface ConfigInterface
 * @package Dykyi\Application\Service
 */
interface ConfigInterface
{
    /**
     * @param array $envConfigs
     * @return Config
     */
    public function parse(array $envConfigs): Config;

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);
}