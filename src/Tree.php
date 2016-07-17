<?php

namespace PhpCategories;

class Tree {

    private $data;

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
                $result = & self::findParentNode($childNode, $parentId);

                if ($result) {
                    break;
                }
            }
        }

        return $result;
    }

}