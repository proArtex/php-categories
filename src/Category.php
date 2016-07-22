<?php

namespace PhpCategories;

class Category extends CategoryBase {

    public function __construct($data, CategoryBase $parent = null) {
        parent::__construct($parent);
        $allowedFields = ['id', 'parentId', 'level', 'name', 'slug', 'children'];

        foreach($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $this->$key = $value;
            }
        }
    }

}