<?php

namespace ProArtex\PhpCategories\DataStructure;

//TODO: __call implementation
abstract class Tree implements ArrayAccessibleInterface {

    const MODE_SILENT = 0;

    const MODE_DEBUG  = 1;

    /**
     * @var Node
     */
    protected $rootNode;

    public function __construct(array $horizontalNodes) {
        $this->build($horizontalNodes);
    }

    public function current() {
        return $this->rootNode->current();
    }

    public function next() {
        $this->rootNode->next();
    }

    public function key() {
        return $this->rootNode->key();
    }

    public function valid() {
        return $this->rootNode->valid();
    }

    public function rewind() {
        $this->rootNode->rewind();
    }

    public function offsetExists($offset) {
        return $this->rootNode->offsetExists($offset);
    }

    public function offsetGet($offset) {
        return $this->rootNode->offsetGet($offset);
    }

    public function offsetSet($offset, $value) {
        $this->rootNode->offsetSet($offset, $value);
    }

    public function offsetUnset($offset) {
        $this->rootNode->offsetUnset($offset);
    }

    abstract protected function getNodeClass();

    private function build(array $horizontalNodes) {
        $nodeClass = $this->getNodeClass();

        $tree = new $nodeClass([
            'id'        => 0,
            'parentId'  => 0,
            'level'     => 0,
            'name'      => 'Root',
            'slug'      => 'root',
            'children'  => [],
            'path'      => new \SplDoublyLinkedList()
        ]);

        $tree->path->push($tree);

        do {
            $isEffectiveIteration = false;

            foreach ($horizontalNodes as $key => &$arrayNode) {
                /**
                 * @var Node $parentNode
                 */
                $parentNode = & $this->findParentNode($tree, $arrayNode['parentId']);

                if ($parentNode) {
                    $isEffectiveIteration = true;
                    $arrayNode['level'] = $parentNode->level + 1;
                    $parentNode->children[] = new $nodeClass($arrayNode, $parentNode->path);
                    unset($horizontalNodes[ $key ]);
                }
            }
        } while ($isEffectiveIteration);


        if ($horizontalNodes) {
            //TODO: throw custom exception
            throw new \Exception('There are ' . count($horizontalNodes) . ' unassigned nodes: ' . implode(', ', array_column($horizontalNodes, 'id')));
        }

        $this->rootNode = $tree;
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