<?php

//header('Content-Type: text/html');

require __DIR__ . '/vendor/autoload.php';


$categories = [
    [
        'id' => 1,
        'parent_id' => 0,
//        'level' => 1,
        'name' => "Electronics",
        'slug' => "electronics",
    ],
    [
        'id' => 5,
        'parent_id' => 0,
//        'level' => 1,
        'name' => "Home",
        'slug' => "home",
    ],
    [
        'id' => 2,
        'parent_id' => 1,
//        'level' => 2,
        'name' => "Sub1",
        'slug' => "sub1",
    ],
    [
        'id' => 4,
        'parent_id' => 3,
//        'level' => 3,
        'name' => "Sub1 - Sub1",
        'slug' => "sub1-sub1",
    ],
    [
        'id' => 3,
        'parent_id' => 1,
//        'level' => 2,
        'name' => "Sub2",
        'slug' => "sub2",
    ],
];

$tree = new \PhpCategories\Tree($categories);
var_dump($tree);
die;