<?php

namespace ProArtex\PhpCategories\DataStructure;

abstract class Iterator implements \Iterator {

    /**
     * @var Node
     */
    protected $node;

    protected $position = [0];

    public function __construct(Node &$node) {
        $this->node = & $node;
    }

    public function current() {
        $current = & $this->node;

        foreach ($this->position as $key) {
            $current = & $current->children[ $key ];
        }

        return $current;
    }

    public function key() {
        return $this->position;
    }

    public function valid() {
        $current = & $this->node;

        if (!$this->position) {
            return false;
        }

        foreach ($this->position as $key) {
            if (!isset($current->children[ $key ])) {
                return false;
            }

            $current = & $current->children[ $key ];
        }

        return true;
    }

    public function rewind() {
        $this->position = [0];
    }

    abstract public function next();

}