<?php

namespace PhpCategories;

class Tree implements \Iterator {

    private $data;

    private $position = [0];

    public function __construct($horizontalCategories) {
        $this->build($horizontalCategories);
    }

    private function build($horizontalCategories) {
        $tree = new Category([
            'id'        => 0,
            'parentId'  => 0,
            'level'     => 0,
            'name'      => 'Root',
            'slug'      => 'root',
            'children'  => []
        ]);

        //TODO: compare prev and curr iteration counters instead
        $maxIterations = count($horizontalCategories);
        $iterations = 0;

        while (++$iterations < $maxIterations) {
            foreach ($horizontalCategories as $key => &$category) {
                $parentCategory = & $this->findParentNode($tree, $category['parentId']);

                if ($parentCategory) {
                    $category['level'] = $parentCategory->level + 1;
                    $parentCategory->children[] = new Category($category);
                    unset($horizontalCategories[ $key ]);
                }
            }
        }

        if ($horizontalCategories) {
            //TODO: throw custom exception
            throw new \Exception('Max cycle of category-tree building has been reached');
        }

        $this->data = $tree;
    }

    private function & findParentNode(&$node, &$parentId) {
        if ($node->id == $parentId) {
            return $node;
        }

        $result = false;

        if (!empty($node->children)) {
            foreach ($node->children as &$childNode) {
                $result = & $this->findParentNode($childNode, $parentId);

                if ($result) {
                    break;
                }
            }
        }

        return $result;
    }

    public function current() {
        $current = $this->data;

        foreach ($this->position as $key) {
            $current = $current->children[ $key ];
        }

        return $current;
    }

    public function next() {
        $current = $this->current();

        if (isset($current->children[0])) {
            $this->position[] = 0;
        }
        else {
            while(count($this->position) > 0) {
                $sameLvlNextPos = array_pop($this->position) + 1;
                $current = $this->current();

                if (isset($current->children[ $sameLvlNextPos ])) {
                    $this->position[] = $sameLvlNextPos;
                    break;
                }
            }
        }
    }

    public function key() {
        return $this->position;
    }

    public function valid() {
        $current = $this->data;

        if (!$this->position) {
            return false;
        }

        foreach ($this->position as $key) {
            if (!isset($current->children[ $key ])) {
                return false;
            }

            $current = $current->children[ $key ];
        }

        return true;
    }

    public function rewind() {
        $this->position = [0];
    }


}