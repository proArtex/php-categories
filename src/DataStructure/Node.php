<?php

namespace ProArtex\PhpCategories\DataStructure;

/**
 * Lazy load implementation
 */
class Node implements NodeInterface {

    public $id;

    public $parentId;

    public $level;

    public $name;

    public $slug;

    public $path;

    public $children = [];

    /**
     * @var \Iterator
     */
    protected $iterator;

    /**
     * @var \ArrayAccess
     */
    protected $arrayAccess;

    public function __construct(\SplDoublyLinkedList $parents = null) {
        $this->buildPath($parents);
    }

    public function current() {
        if (!$this->iterator) {
            $this->iterator = $this->getSuitableIterator();
        }

        return $this->iterator->current();
    }

    public function next() {
        if (!$this->iterator) {
            $this->iterator = $this->getSuitableIterator();
        }

        $this->iterator->next();
    }

    public function key() {
        if (!$this->iterator) {
            $this->iterator = $this->getSuitableIterator();
        }

        return $this->iterator->key();
    }

    public function valid() {
        if (!$this->iterator) {
            $this->iterator = $this->getSuitableIterator();
        }

        return $this->iterator->valid();
    }

    public function rewind() {
        if (!$this->iterator) {
            $this->iterator = $this->getSuitableIterator();
        }

        $this->iterator->rewind();
    }

    public function offsetExists($offset) {
        if (!$this->arrayAccess) {
            $this->arrayAccess = $this->getSuitableArrayAccess();
        }

        return $this->arrayAccess->offsetExists($offset);
    }

    public function offsetGet($offset) {
        if (!$this->arrayAccess) {
            $this->arrayAccess = $this->getSuitableArrayAccess();
        }
        
        return $this->arrayAccess->offsetGet($offset);
    }

    //TODO: make it smart (validate levels, parents, etc.)
    public function offsetSet($offset, $value) {
        if (!$this->arrayAccess) {
            $this->arrayAccess = $this->getSuitableArrayAccess();
        }

        $this->arrayAccess->offsetSet($offset,$value);
    }

    public function offsetUnset($offset) {
        if (!$this->arrayAccess) {
            $this->arrayAccess = $this->getSuitableArrayAccess();
        }

        $this->arrayAccess->offsetUnset($offset);
    }

    public function getPathFor($property) {
        if (property_exists($this, $property) && $this->path) {
            $path = [];

            foreach ($this->path as $node) {
                $path[] = $node->{$property};
            }

            return $path;
        }

        return [];
    }

    public function setIterator($iteratorClass, $recursive = true) {
        if (isset(class_implements($iteratorClass)['Iterator'])) {
            $this->iterator = new $iteratorClass($this);

            if ($recursive) {
                foreach ($this as $node) {
                    /**
                     * @var Node $node
                     */
                    $node->setIterator(new $iteratorClass($node), false);
                }
            }
        }
    }

    public function setArrayAccess($arrayAccessClass, $recursive = true) {
        if (isset(class_implements($arrayAccessClass)['ArrayAccess'])) {
            $this->arrayAccess = new $arrayAccessClass($this);

            if ($recursive) {
                foreach ($this as $node) {
                    /**
                     * @var Node $node
                     */
                    $node->setArrayAccess(new $arrayAccessClass($node), false);
                }
            }
        }
    }

    protected function getSuitableIterator() {
        foreach ($this->path as $node) {
            if ($node->iterator) {
                $iteratorClass = get_class($node->iterator);
                return new $iteratorClass($this);
            }
        }

        return new HorizontalIterator($this);
    }

    protected function getSuitableArrayAccess() {
        foreach ($this->path as $node) {
            if ($node->arrayAccess) {
                $arrayAccessClass = get_class($node->arrayAccess);
                return new $arrayAccessClass($this);
            }
        }

        return new ArrayAccess($this);
    }

    private function buildPath(\SplDoublyLinkedList $parents = null) {
        $this->path = new \SplDoublyLinkedList();

        if ($parents) {
            foreach ($parents as $parent) {
                $this->path->push($parent);
            }
        }

        $this->path->push($this);
    }

}