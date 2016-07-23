<?php

namespace ProArtex\PhpCategories;

use ProArtex\PhpCategories\DataStructure\Node;

class Category extends Node {

    public function __construct($data, \SplDoublyLinkedList $parents = null) {
        parent::__construct($parents);
        $allowedFields = ['id', 'parentId', 'level', 'name', 'slug', 'children', 'path'];

        foreach($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $this->$key = $value;
            }
        }
    }

}