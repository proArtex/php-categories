<?php

namespace PhpCategories;

interface ArrayAccessibleInterface extends \Iterator, \ArrayAccess { //Countable

    public function current();

    public function next();

    public function key();

    public function valid();

    public function rewind();

    public function offsetExists($offset);

    public function offsetGet($offset);

    public function offsetSet($offset, $value);

    public function offsetUnset($offset);

//    public function count();

}