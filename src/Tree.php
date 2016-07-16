<?php

namespace PhpCategories;

class Tree {

    public function __construct($horizontalCategories) {
        var_dump($this->build($horizontalCategories));
    }

    private function build($horizontalCategories, $rootId = 0) {
        $tree = [
            'id'        => $rootId,
            'slug'      => 'root',
            'parent_id' => 0,
            'level'     => 0,
            'children'  => []
        ];

        $maxIterations = count($horizontalCategories);
        $iterations = 0;

        while (++$iterations < $maxIterations) {
            foreach ($horizontalCategories as $key => &$category) {
                $parentCategory = & $this->findParentNode($tree, $category['parent_id']);

                if ($parentCategory) {
                    $category['level'] = $parentCategory['level'] + 1;
                    $parentCategory['children'][] = $category;
                    unset($horizontalCategories[ $key ]);
                }
            }
        }

        if ($horizontalCategories) {
            //TODO: throw custom exception
            throw new \Exception('Max cycle of category-tree building has been reached');
        }

        return $tree;
    }

    private function & findParentNode(&$node, &$parentId) {
        if ($node['id'] == $parentId) {
            return $node;
        }

        $result = false;

        if (!empty($node['children'])) {
            foreach ($node['children'] as &$childNode) {
                $result = & self::findParentNode($childNode, $parentId);

                if ($result) {
                    break;
                }
            }
        }

        return $result;
    }

}