<?php

namespace PhpCategories;

class Tree implements \Iterator, \ArrayAccess { //Countable

    private $data;

    private $iterator;

    private $arrayAccess;

    public function __construct(array $horizontalCategories) {
        $this->build($horizontalCategories);
        $this->iterator = new HorizontalIterator($this->data);
        $this->arrayAccess = new ArrayAccess($this->data);
    }

    public function current() {
        return $this->iterator->current();
    }

    public function next() {
        $this->iterator->next();
    }

    public function key() {
        return $this->iterator->key();
    }

    public function valid() {
        return $this->iterator->valid();
    }

    public function rewind() {
        $this->iterator->rewind();
    }

    public function offsetExists($offset) {
        return $this->arrayAccess->offsetExists($offset);
    }

    public function offsetGet($offset) {
        return $this->arrayAccess->offsetGet($offset);
    }

    public function offsetSet($offset, $value) {
        $this->arrayAccess->offsetSet($offset,$value);
    }

    public function offsetUnset($offset) {
        $this->arrayAccess->offsetUnset($offset);
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
}