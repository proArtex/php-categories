<?php

namespace ProArtex\PhpCategories;

use ProArtex\PhpCategories\DataStructure\Tree;

class CategoryTree extends Tree {

    protected function getNodeClass() {
        return Category::class;
    }

}