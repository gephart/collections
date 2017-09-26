<?php

namespace Gephart\Collections;
use Gephart\Collections\Exception\BadTypeException;

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
    private $type;

    public function __construct(string $type = null)
    {
        $this->type = $type;
    }

    public function collect(array $items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add($item)
    {
        if ($this->type && !$item instanceof $this->type) {
            throw new BadTypeException("Item to add to collection must be type of " . $this->type);
        }

        $this->list[] = $item;
    }

    public function get($index)
    {
        return $this->list[$index];
    }

    public function all(): array
    {
        return $this->list;
    }

    /**
     * Unset item by index
     *
     * @param $index
     */
    public function remove($index)
    {
        unset($this->list[$index]);
    }

    public function count()
    {
        return count($this->list);
    }

    public function jsonSerialize()
    {
        return json_encode($this->list);
    }

    public function getIterator() {
        return new \ArrayIterator($this->list);
    }
}