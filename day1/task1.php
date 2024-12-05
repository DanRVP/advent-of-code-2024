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
        insert($a, $a1);
        insert($b, $a2);
    }

    fclose($handle);

    $res = 0;
    $count_a = count($a1);
    for ($k = 0; $k < $count_a; $k++) {
        $a = $a1[$k];
        $b = $a2[$k];
        if ($a > $b) {
            $res += ($a - $b);
        } else {
            $res += ($b - $a);
        }
    }

    echo $res . "\n";
}

run();
