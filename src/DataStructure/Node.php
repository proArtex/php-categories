<?php

namespace ProArtex\PhpCategories\DataStructure;

/**
 * Lazy load implementation
 * TODO: get parents's Iterator & ArrayAccess first
 */
class Node implements ArrayAccessibleInterface {

    public $id;

    public $parentId;

    public $level;

    public $name;

    public $slug;

    public $parent;

    public $children = [];

    /**
     * @var \Iterator
     */
    protected $iterator;

    /**
     * @var \ArrayAccess
     */
    protected $arrayAccess;

    public function __construct(Node $parent = null) {
        $this->parent = $parent;
    }

    public function current() {
        if (!$this->iterator) {
            $this->iterator = $this->getDefaultIterator();
        }

        return $this->iterator->current();
    }

    public function next() {
        if (!$this->iterator) {
            $this->iterator = $this->getDefaultIterator();
        }

        $this->iterator->next();
    }

    public function key() {
        if (!$this->iterator) {
            $this->iterator = $this->getDefaultIterator();
        }

        return $this->iterator->key();
    }

    public function valid() {
        if (!$this->iterator) {
            $this->iterator = $this->getDefaultIterator();
        }

        return $this->iterator->valid();
    }

    public function rewind() {
        if (!$this->iterator) {
            $this->iterator = $this->getDefaultIterator();
        }

        $this->iterator->rewind();
    }

    public function offsetExists($offset) {
        if (!$this->arrayAccess) {
            $this->arrayAccess = $this->getDefaultArrayAccess();
        }

        return $this->arrayAccess->offsetExists($offset);
    }

    public function offsetGet($offset) {
        if (!$this->arrayAccess) {
            $this->arrayAccess = $this->getDefaultArrayAccess();
        }

        return $this->arrayAccess->offsetGet($offset);
    }

    public function offsetSet($offset, $value) {
        if (!$this->arrayAccess) {
            $this->arrayAccess = $this->getDefaultArrayAccess();
        }

        $this->arrayAccess->offsetSet($offset,$value);
    }

    public function offsetUnset($offset) {
        if (!$this->arrayAccess) {
            $this->arrayAccess = $this->getDefaultArrayAccess();
        }

        $this->arrayAccess->offsetUnset($offset);
    }

    public function getPathFor($property) {
        if (property_exists($this, $property) && $this->parent) {
            $path = [];
            $current = $this;

            do {
                array_unshift($path, $current->{$property});
                $current = $current->parent;
            } while ($current);

            return $path;
        }

        return [];
    }

    public function setIterator(\Iterator $iterator) {
        $this->iterator = $iterator;
    }

    public function setArrayAccess(\ArrayAccess $arrayAccess) {
        $this->arrayAccess = $arrayAccess;
    }

    protected function getDefaultIterator() {
        return new HorizontalIterator($this);
    }

    protected function getDefaultArrayAccess() {
        return new ArrayAccess($this);
    }

}