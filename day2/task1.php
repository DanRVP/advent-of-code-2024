<?php

function check(array $arr)
{
    $size = count($arr);
    $increasing = false;
    for ($i = 1; $i < $size; $i++) {
        $incr = $arr[$i] > $arr[$i - 1];
        if ($i === 1) {
            $increasing = $incr;
        }

        if ($increasing !== $incr) {
            return false;
        }

        $diff = abs($arr[$i] - $arr[$i - 1]);
        if ($diff === 0 || $diff > 3) {
            return false;
        }
    }

    return true;
}

$safe_count = 0;
$handle = fopen(__DIR__ . '/input.txt', 'r');
while (($line = fgets($handle)) !== false) {
    $arr = explode(' ', $line);
    if (check($arr)) {
        $safe_count++;
    }
}

echo $safe_count . "\n";
