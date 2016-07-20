<?php

namespace PhpCategories;

class HorizontalIterator extends Iterator {

    public function next() {
        $current = & $this->getCurrent();

        if (isset($current->children[0])) {
            $this->position[] = 0;
        }
        else {
            while(count($this->position) > 0) {
                $sameLvlNextPos = array_pop($this->position) + 1;
                $current = & $this->getCurrent();

                if (isset($current->children[ $sameLvlNextPos ])) {
                    $this->position[] = $sameLvlNextPos;
                    break;
                }
            }
        }
    }

    //TODO: remove
    private function & getCurrent() {
        $current = & $this->data;

        foreach ($this->position as $key) {
            $current = & $current->children[ $key ];
        }

        return $current;
    }
}