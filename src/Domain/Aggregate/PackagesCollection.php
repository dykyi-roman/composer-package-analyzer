<?php

namespace Dykyi\Domain\Aggregate;

use Dykyi\Domain\ValueObject\Package;

/**
 * Created by t4web/ComposerLockParser
 *
 * Class PackagesCollection
 */
class PackagesCollection extends \ArrayObject
{
    /**
     * @var array
     */
    private $indexedBy;
    /**
     * @param string $name
     *
     * @return Package
     */
    public function getByName($name)
    {
        if (!$this->hasByName($name)) {
            throw new \UnexpectedValueException(sprintf('Package %s not exists', $name));
        }
        return $this->getIndexedByName()[$name];
    }
    /**
     * @param string $namespace
     *
     * @return Package
     */
    public function getByNamespace($namespace)
    {
        if (!$this->hasByNamespace($namespace)) {
            throw new \UnexpectedValueException(sprintf('Package %s not exists', $namespace));
        }
        return $this->getIndexedByNamespace()[$namespace];
    }
    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasByName($name)
    {
        return array_key_exists($name, $this->getIndexedByName());
    }
    /**
     * @param string $namespace
     *
     * @return bool
     */
    public function hasByNamespace($namespace)
    {
        return array_key_exists($namespace, $this->getIndexedByNamespace());
    }
    public function offsetSet($index, $package)
    {
        if ($package instanceof Package) {
            $this->indexedBy['name'][$package->getName()] = $package;
            $this->indexedBy['namespace'][$package->getNamespace()] = $package;
        }
        return parent::offsetSet($index, $package);
    }
    /**
     * @return array
     */
    private function getIndexedByName()
    {
        if (!empty($this->indexedBy['name'])) {
            return $this->indexedBy['name'];
        }
        /** @var Package $package */
        foreach($this->getArrayCopy() as $package) {
            if (!($package instanceof Package)) {
                continue;
            }
            $this->indexedBy['name'][$package->getName()] = $package;
        }
        return $this->indexedBy['name'];
    }
    /**
     * @return array
     */
    private function getIndexedByNamespace()
    {
        if (!empty($this->indexedBy['namespace'])) {
            return $this->indexedBy['namespace'];
        }
        /** @var Package $package */
        foreach($this->getArrayCopy() as $package) {
            if (!($package instanceof Package)) {
                continue;
            }
            $this->indexedBy['namespace'][$package->getNamespace()] = $package;
        }
        return $this->indexedBy['namespace'];
    }
}