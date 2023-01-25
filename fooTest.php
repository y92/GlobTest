<?php

require_once __DIR__.'/src/Foo.php';

// Fichier test pour la fonction Foo

$testArrays = [
    [[0,3],[6,10]],
    [[0,5],[3,10]],
    [[0,5],[2,4]],
    [[7,8],[3,6],[2,4]],
    [[3,6],[3,4],[15,20],[16,17],[1,4],[6,10],[3,6]]
];

$len = count($testArrays);

$testFoos = [];

foreach ($testArrays as $elt) {
    $testFoos[] = Foo::foo($elt);
}

for ($k=0; $k<$len; $k++) {
    echo '$array'.($k+1).' = '.Foo::makeString($testArrays[$k])."\n";
}

echo "\n";

for ($k=0; $k<$len; $k++) {
    echo 'foo($array'.($k+1).') = '.Foo::makeString($testFoos[$k])."\n";
}