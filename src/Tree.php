<?php

namespace PhpCategories;

class Tree implements \Iterator, \ArrayAccess {

    const MODE_SILENT = 0;

    const MODE_DEBUG  = 1;

    /**
     * @var CategoryBase
     */
    private $rootCategory;

    public function __construct(array $horizontalCategories) {
        $this->build($horizontalCategories);
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

    private function build(array $horizontalCategories) {
        $tree = new Category([
            'id'        => 0,
            'parentId'  => 0,
            'level'     => 0,
            'name'      => 'Root',
            'slug'      => 'root',
            'children'  => []
        ]);

        do {
            $isEffectiveIteration = false;

            foreach ($horizontalCategories as $key => &$arrayCategory) {
                $parentCategory = & $this->findParentNode($tree, $arrayCategory['parentId']);

                if ($parentCategory) {
                    $isEffectiveIteration = true;
                    $arrayCategory['level'] = $parentCategory->level + 1;
                    $parentCategory->children[] = new Category($arrayCategory, $parentCategory);
                    unset($horizontalCategories[ $key ]);
                }
            }
        } while ($isEffectiveIteration);


        if ($horizontalCategories) {
            //TODO: throw custom exception
            throw new \Exception('There are ' . count($horizontalCategories) . ' unassigned categories: ' . implode(', ', array_column($horizontalCategories, 'id')));
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

}