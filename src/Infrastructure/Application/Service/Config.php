<?php

namespace Dykyi\Infrastructure\Service;

use Dykyi\Application\Service\ConfigInterface;

/**
 * Class Config
 * @package Building\Infrastructure\Service
 */
class Config implements ConfigInterface
{
    private $keys = [];

    /**
     * @param array $envConfigs
     * @return Config
     */
    public function parse(array $envConfigs): self
    {
        foreach ($envConfigs as $item) {
            $elements = explode('=', $item);
            $this->keys[$elements[0]] = $elements[1];
        }
        return $this;
    }

    public function get(string $key)
    {
        if (!array_key_exists($key, $this->keys)) {
            return null;
        }

        return $this->keys[$key];
    }
}