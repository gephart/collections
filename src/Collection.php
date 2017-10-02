<?php

namespace Gephart\Collections;

use Gephart\Collections\Exception\InvalidTypeException;

/**
 * Collection
 *
 * @package Gephart\Collections
 * @author Michal Katuščák <michal@katuscak.cz>
 * @since 0.5
 */
class Collection implements \IteratorAggregate, \Countable, \JsonSerializable
{

    /**
     * @var array
     */
    protected $list = [];

    /**
     * @var string
     */
    protected $type;

    /**
     * @param string|null $type
     */
    public function __construct(string $type = null)
    {
        $this->type = $type;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function collect(array $items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }

        return $this;
    }

    /**
     * @param $item
     * @return self
     * @throws InvalidTypeException
     */
    public function add($item)
    {
        if ($this->type && !$item instanceof $this->type) {
            throw new InvalidTypeException("Item to add to collection must be type of " . $this->type);
        }

        $this->list[] = $item;

        return $this;
    }

    /**
     * @param int $index
     * @return mixed
     */
    public function get(int $index)
    {
        return $this->list[$index];
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->list;
    }

    /**
     * Unset item by index
     *
     * @param $index
     * @return self
     */
    public function remove($index)
    {
        unset($this->list[$index]);
        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->list);
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return json_encode($this->list);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->list);
    }

    /**
     * @param callable $callback
     * @return self
     */
    public function map(callable $callback)
    {
        $list = array_map($callback, $this->list);
        return (new static($this->type))->collect($list);
    }

    /**
     * @param callable $callback
     * @return self
     */
    public function filter(callable $callback)
    {
        $list = array_filter($this->list, $callback);
        return (new static($this->type))->collect($list);
    }

    /**
     * @param callable $callback
     * @return self
     */
    public function sort(callable $callback)
    {
        $list = $this->list;
        usort($list, $callback);
        return (new static($this->type))->collect($list);
    }

    /**
     * @param callable $callback
     * @return self
     */
    public function each(callable $callback)
    {
        foreach ($this->list as $key => $item) {
            if (!$callback($item, $key)) {
                break;
            }
        }

        return $this;
    }
}
