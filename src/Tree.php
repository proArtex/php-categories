<?php

namespace PhpCategories;

class Tree implements \Iterator, \ArrayAccess {

    /**
     * @var CategoryBase
     */
    private $rootCategory;

    public function __construct(array $horizontalCategories) {
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

        //TODO: compare prev and curr iteration counters instead (return or throw Exception)
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

        $this->rootCategory = $tree;
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
        return $this->rootCategory->current();
    }

    public function next() {
        $this->rootCategory->next();
    }

    public function key() {
        return $this->rootCategory->key();
    }

    public function valid() {
        return $this->rootCategory->valid();
    }

    public function rewind() {
        $this->rootCategory->rewind();
    }

    public function offsetExists($offset) {
        return $this->rootCategory->offsetExists($offset);
    }

    public function offsetGet($offset) {
        return $this->rootCategory->offsetGet($offset);
    }

    public function offsetSet($offset, $value) {
        $this->rootCategory->offsetSet($offset, $value);
    }

    public function offsetUnset($offset) {
        $this->rootCategory->offsetUnset($offset);
    }

}