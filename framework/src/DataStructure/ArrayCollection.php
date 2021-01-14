<?php


namespace LightFramework\DataStructure;


use ArrayIterator;
use Countable;
use IteratorAggregate;

class ArrayCollection implements IteratorAggregate, Countable
{
    /**
     * Parameters who are stored
     *
     * @var array
     */
    protected array $parameters;

    /**
     * ParamsBag constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * Get all parameters
     *
     * @return array
     */
    public function all(): array
    {
        return $this->parameters;
    }

    /**
     * Get parameter
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
    }

    /**
     * Set new parameter
     *
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value): void
    {
        $this->parameters[$key] = $value;
    }

    /**
     * Remove an element from array
     *
     * @param string $key
     */
    public function remove(string $key): void
    {
        unset($this->parameters[$key]);
    }

    /**
     * Returns an iterator for parameters.
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->parameters);
    }

    /**
     * Return number of parameters
     *
     * @return int|void
     */
    public function count(): int
    {
        return count($this->parameters);
    }
}