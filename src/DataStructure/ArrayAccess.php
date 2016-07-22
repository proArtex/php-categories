<?php

namespace ProArtex\PhpCategories\DataStructure;

//TODO: warnings
class ArrayAccess implements \ArrayAccess {

    /**
     * @var Node
     */
    protected $node;

    public function __construct(Node &$node) {
        $this->node = & $node;
    }

    public function offsetExists($offset) {
        return (boolean) $this->offsetGet($offset);
    }

    public function offsetGet($offset) {
        if ($offset && is_array($offset)) {
            $current = & $this->node;

            foreach ($offset as $key) {
                if (!isset($current->children[ $key ])) {
                    return null;
                }

                $current = & $current->children[ $key ];
            }

            return $current;
        }

        return null;
    }

    //FIXME: unsafe op
    public function offsetSet($offset, $value) {
        if ($value instanceof Node) {
            if (is_null($offset)) {
                $this->node->children[] = $value;
            }
            elseif ($offset && is_array($offset)) {
                list($parentNode, $key) = $this->getNodeCoordinates($offset);

                if ($parentNode) {
                    $parentNode->children[ $key ] = $value;
                }
            }
        }
    }

    public function offsetUnset($offset) {
        if ($offset && is_array($offset)) {
            list($parentNode, $key) = $this->getNodeCoordinates($offset);

            if ($parentNode) {
                unset($parentNode->children[ $key ]);
            }
        }
    }

    private function getNodeCoordinates(array $offset) {
        $isFirstLvl = (count($offset) == 1);

        if ($isFirstLvl) {
            $key = current($offset);
            $parentNode = & $this->node;
        }
        else {
            $key = array_pop($offset);
            $parentNode = $this->offsetGet($offset);
        }

        return [$parentNode, $key];
    }

}