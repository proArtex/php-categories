<?php

//header('Content-Type: text/html');

require __DIR__ . '/vendor/autoload.php';


$categories = [
    [
        'id' => 1,
        'parentId' => 0,
        'name' => "Electronics",
        'slug' => "electronics",
    ],
    [
        'id' => 5,
        'parentId' => 0,
        'name' => "Home",
        'slug' => "home",
    ],
    [
        'id' => 2,
        'parentId' => 1,
        'name' => "Sub1",
        'slug' => "sub1",
    ],
    [
        'id' => 6,
        'parentId' => 0,
        'name' => "Something",
        'slug' => "something",
    ],
    [
        'id' => 4,
        'parentId' => 3,
        'name' => "Sub2 - Sub1",
        'slug' => "sub2-sub1",
    ],
    [
        'id' => 7,
        'parentId' => 6,
        'name' => "Sub3",
        'slug' => "sub3",
    ],
    [
        'id' => 3,
        'parentId' => 1,
        'name' => "Sub2",
        'slug' => "sub2",
    ],
//    [
//        'id' => 33,
//        'parentId' => 12,
//        'name' => "Sub2",
//        'slug' => "sub2",
//    ],
//    [
//        'id' => 34,
//        'parentId' => 13,
//        'name' => "Sub2",
//        'slug' => "sub2",
//    ],
//    [
//        'id' => 35,
//        'parentId' => 14,
//        'name' => "Sub2",
//        'slug' => "sub2",
//    ],
];

$tree = new \ProArtex\PhpCategories\CategoryTree($categories);

//foreach ($tree as $key => $category) {
//    var_dump(isset($tree[ $key ]));
//    var_dump($tree[ $key ]->slug);
//    var_dump($category->name);
//}
//
//var_dump(isset($tree[[0,1,0,0]]));
//unset($tree[[0,0]]);
//unset($tree[[2]]);
//unset($tree[[3]]);
//$tree[] = $tree[[0,1]];
//$tree[[5]] = $tree[[2]];

var_dump($tree);
die;