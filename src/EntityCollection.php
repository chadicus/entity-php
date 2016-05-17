<?php

namespace Chadicus\Entity;

use Chadicus\Spl\Traits\IteratorTrait;
use DominionEnterprises\Util;

/**
 * Represents a collection of entities.
 */
final class EntityCollection implements EntityInterface, \Iterator, \ArrayAccess
{
    use IteratorTrait;

    /**
     * Array of EntityInterface objects.
     *
     * @var EntityInterface[]
     */
    private $container = [];

    /**
     * Sets the value at the specified index $offset to $value.
     *
     * @param integer $offset The index being set.
     * @param mixed   $value  The new value for the index.
     *
     * @return void
     *
     * @throws \InvalidArgumentException Thrown if $offset is not null and is not an integer.
     */
    public function offsetSet($offset, $value)
    {
        Util::ensure(
            true,
            $value instanceof EntityInterface,
            '\InvalidArgumentException',
            ['$value must be an instance of EntityInterface', 400]
        );

        if ($offset === null) {
            $this->container[] = $value;
            return;
        }

        $offset = Util::ensureNot(
            false,
            filter_var($offset, FILTER_VALIDATE_INT),
            '\InvalidArgumentException',
            ['$offset must be an integer', 400]
        );

        $this->container[$offset] = $value;
    }

    /**
     * Returns whether the requested index exists.
     *
     * @param integer $offset The index being checked.
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        $offset = filter_var($offset, FILTER_VALIDATE_INT);
        if ($offset !== false) {
            return array_key_exists($offset, $this->container);
        }

        return false;
    }

    /**
     * Unsets the value at the specified index.
     *
     * @param integer $offset The index being unset.
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        $offset = filter_var($offset, FILTER_VALIDATE_INT);
        if ($offset !== false) {
            unset($this->container[$offset]);
        }
    }

    /**
     * Returns the value at the specified index.
     *
     * @param integer $offset The index with the value.
     *
     * @return EntityInterface|null
     */
    public function offsetGet($offset)
    {
        $offset = filter_var($offset, FILTER_VALIDATE_INT);
        if ($offset === false) {
            return null;
        }

        return Util\Arrays::get($this->container, $offset);
    }

    /**
     * Converts this entity collection into an xml string.
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->container;
    }
}
