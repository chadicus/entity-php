<?php

namespace Chadicus\Entity;

use Chadicus\Spl\Exceptions\UndefinedPropertyException;
use DominionEnterprises\Filterer;
use DominionEnterprises\Util;

/**
 * Adds additional functionality to entity implementations.
 */
abstract class AbstractEntity implements EntityInterface
{
    /**
     * The data for this AbstractEntity
     *
     * @var array
     */
    private $data = [];

    /**
     * Create a new AbstractEntity based on the given $input array.
     *
     * @param array $input The data for the EntityInterface.
     */
    final public function __construct(array $input = [])
    {
        list($success, $filtered, $error) = Filterer::filter($this->getFilters(), $input, ['allowUnknowns' => true]);
        Util::ensure(true, $success, '\InvalidArgumentException', [$error]);

        foreach ($filtered as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Get an AbstractEntity property.
     *
     * @param string $name The name of the property.
     *
     * @return mixed
     *
     * @throws UndefinedPropertyException Thrown if $name is not a valid class property.
     */
    final public function __get($name)
    {
        if (!array_key_exists($name, $this->data)) {
            $class = get_called_class();
            throw new UndefinedPropertyException("Undefined Property {$class}::\${$name}");
        }

        return $this->data[$name];
    }

    /**
     * Allows for getX() method calls.
     *
     * @param string $name      The name of the method being called.
     * @param array  $arguments The arguments being passed to the method. This parameter is unused.
     *
     * @return mixed
     *
     * @throws \BadMethodCallException Thrown if the property being accessed does not exist.
     */
    final public function __call($name, array $arguments = [])
    {
        if (substr($name, 0, 3) !== 'get') {
            $class = get_called_class();
            throw new \BadMethodCallException("Method {$class}::{$name}() does not exist");
        }

        $key = lcfirst(substr($name, 3));

        if (!array_key_exists($key, $this->data)) {
            $class = get_called_class();
            throw new \BadMethodCallException("Method {$class}::{$name}() does not exist");
        }

        return $this->data[$key];
    }

    /**
     * Create an array of new AbstractEntity based on the given $input arrays.
     *
     * @param array[] $inputs The value to be filtered.
     *
     * @return EntityCollection
     */
    final public static function fromArrays(array $inputs)
    {
        Util::throwIfNotType(['array' => $inputs]);

        $entities = new EntityCollection();
        foreach ($inputs as $key => $input) {
            $entities[$key] = new static($input);
        }

        return $entities;
    }

    /**
     * Create a new AbstractEntity based on the given $input array.
     *
     * @param array $input The data for the AbstractEntity.
     *
     * @return AbstractEntity
     */
    final public static function fromArray(array $input)
    {
        return new static($input);
    }

    /**
     * Returns the data for this object which can be serialized to JSON.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * Returns an array of filters suitable for use with \DominionEnterprises\Filterer::filter().
     *
     * @return array
     */
    abstract protected function getFilters();
}
