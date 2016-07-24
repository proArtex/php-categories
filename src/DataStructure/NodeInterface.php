<?php

namespace ProArtex\PhpCategories\DataStructure;

interface NodeInterface extends ArrayAccessibleInterface {

    public function getPathFor($property);

    public function setIterator($iteratorClass, $recursive = true);

    public function setArrayAccess($arrayAccessClass, $recursive = true);

}