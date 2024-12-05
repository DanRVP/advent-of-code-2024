<?php

function insert($value, &$arr)
{
    if (empty($arr)) {
        $arr[] = $value;
        return;
    }

    $size = count($arr);
    if ($value > $arr[$size -1]) {
        $arr[] = $value;
        return;
    }

    for ($j = $size - 1; $j >= 0 && $arr[$j] > $value; $j--) {
        $arr[$j + 1] = $arr[$j];
    }

    $arr[$j + 1] = $value;
}

function run()
{
    $a1 = [];
    $a2 = [];

    $handle = fopen(__DIR__ . '/input.txt', 'r');
    while (($line = fgets($handle)) !== false) {
        list($a, $b) = explode('   ', $line);
        $a1[] = $a;
        $a2[] = $b;
    }

    fclose($handle);

    $res = 0;
    foreach ($a1 as $a) {
        $occurs = 0;
        foreach ($a2 as $b) {
            if ($a == $b) {
                $occurs++;
            }
        }

        $res+= ($a * $occurs);
    }

    echo $res . "\n";
}

run();
