<?php

//header('Content-Type: text/html');

require __DIR__ . '/vendor/autoload.php';


$categories = [
    [
        'id' => 1,
        'parentId' => 0,
//        'level' => 1,
        'name' => "Electronics",
        'slug' => "electronics",
    ],
    [
        'id' => 5,
        'parentId' => 0,
//        'level' => 1,
        'name' => "Home",
        'slug' => "home",
    ],
    [
        'id' => 2,
        'parentId' => 1,
//        'level' => 2,
        'name' => "Sub1",
        'slug' => "sub1",
    ],
    [
        'id' => 6,
        'parentId' => 0,
//        'level' => 1,
        'name' => "Something",
        'slug' => "something",
    ],
    [
        'id' => 4,
        'parentId' => 3,
//        'level' => 3,
        'name' => "Sub2 - Sub1",
        'slug' => "sub2-sub1",
    ],
    [
        'id' => 7,
        'parentId' => 6,
//        'level' => 1,
        'name' => "Sub3",
        'slug' => "sub3",
    ],
    [
        'id' => 3,
        'parentId' => 1,
//        'level' => 2,
        'name' => "Sub2",
        'slug' => "sub2",
    ],
];

$tree = new \PhpCategories\Tree($categories);

foreach ($tree as $key => $category) {
//    var_dump($key);
    var_dump($category->name);
}


//var_dump($tree);
die;