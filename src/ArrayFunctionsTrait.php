<?php

namespace Gephart\Collections;

/**
 * Array functions
 *
 * @package Gephart\Collections
 * @author Michal Katuščák <michal@katuscak.cz>
 * @since 0.5
 */
trait ArrayFunctionsTrait
{
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
}
