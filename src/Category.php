<?php

namespace PhpCategories;

class Category {

    public $id;

    public $parentId;

    public $level;

    public $name;

    public $slug;

    public $children = [];

    public function __construct($data) {
        $allowedFields = ['id', 'parentId', 'level', 'name', 'slug', 'children'];

        foreach($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $this->$key = $value;
            }
        }
    }

}