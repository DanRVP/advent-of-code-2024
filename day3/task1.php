<?php

$contents = file_get_contents(__DIR__ . '/input.txt');
preg_match_all('/(mul\((\d{1,3}),(\d{1,3})\))/', $contents, $matches);

$result = 0;
$len = count($matches[2]); // Direct numeric matches go into keys 2 and 3. Will be same length.
for ($i = 0; $i < $len; $i++) {
    $result += ($matches[2][$i] * $matches[3][$i]);
}

echo $result . "\n";
