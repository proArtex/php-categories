<?php

namespace ProArtex\PhpCategories\DataStructure;

class HorizontalIterator extends Iterator {

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

}