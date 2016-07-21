<?php

namespace PhpCategories;

abstract class Iterator implements \Iterator {

    protected $data;

    protected $position = [0];

    public function __construct(CategoryBase &$data) {
        $this->data = & $data;
    }

    public function current() {
        $current = & $this->data;

        foreach ($this->position as $key) {
            $current = & $current->children[ $key ];
        }

        return $current;
    }

    public function key() {
        return $this->position;
    }

    public function valid() {
        $current = & $this->data;

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