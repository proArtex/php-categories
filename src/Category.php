<?php

namespace ProArtex\PhpCategories;

use ProArtex\PhpCategories\DataStructure\Node;

class Category extends Node {

    public function __construct($data, Node $parent = null) {
        parent::__construct($parent);
        $allowedFields = ['id', 'parentId', 'level', 'name', 'slug', 'children'];

        foreach($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $this->$key = $value;
            }
        }
    }

}