<?php

$contents = file_get_contents(__DIR__ . '/input.txt');
$chars = str_split($contents);

$result = 0;
$current_string = '';
$valid_chars = ['d', 'o', 'n', "'", 't', 'm', 'u', 'l', '(', '', ')'];

$do_mul = true;

$mul_count = 0;
$do_count = 0;
$dont_count = 0;

$act_mul = preg_match_all('/(mul\((\d{1,3}),(\d{1,3})\))/', $contents);
$act_do = preg_match_all('/(do\(\))/', $contents);
$act_dont = preg_match_all('/(don\'t\(\))/', $contents);

foreach ($chars as $i => $char) {
    $current_string .= $char;
    if (!in_array($char, $valid_chars)) {
        $current_string = '';
        continue;
    }


    if (
        !checkString($current_string, "do(")
        && !checkString($current_string, "don't(")
        && !checkString($current_string,"mul(")
    ) {
        // invalid value incoming
        $current_string = '';
        continue;
    }

    if ($current_string === 'do(' && $chars[$i + 1] === ')') {
        $do_mul = true;
        $do_count ++;
        echo "\nmul() actived at char " . $i + 1  . "\n";
        $current_string = '';
        continue;
    }

    if ($current_string === "don't(" && $chars[$i + 1] === ')') {
        $do_mul = false;
        $dont_count++;
        echo "\nmul() deactived at char " . $i + 1 . "\n";
        $current_string = '';
        continue;
    }

    if ($current_string === 'mul(') {
        $vals = '';
        for ($j = 0; $j <= 9; $j++) {
            $eval = $chars[$i + $j];
            if (!is_numeric($eval) && !in_array($eval, [',',  '(', ')'])) {
                break;
            }

            $vals .= $eval;
            if ($eval === ')') {
                break;
            }
        }

        if (preg_match('/\((\d{1,3}),(\d{1,3})\)/', $vals, $matches)) {
            echo "Found {$matches[1]},{$matches[2]} at char " . $i + $j . "\n";
            $mul_count++;
            if ($do_mul) {
                echo "Adding {$matches[1]},{$matches[2]}\n";
                $result += ($matches[1] * $matches[2]);
            }

            $current_string = '';
        } else {
            echo "bad val: $vals\n";
        }
    }
}

echo <<<EOD

Result: $result

mul() count: $mul_count
do() count: $do_count
don't() count: $dont_count

actual mul() count: $act_mul
actual do() count: $act_do
actual don't() count: $act_dont

EOD;

/**
 * Check that a a needle can be derived from a haystack, but respect string order.
 *
 * For example checking "(" is in the string "do()" is technically true,
 * but there is no possible way by adding another char after "(" that I can form the string "do()".
 */
function checkString(string $needle, string $haystack): bool
{
    $arr_n = str_split($needle);
    $arr_h = str_split($haystack);
    $len = count($arr_h);

    for ($i = 0; $i < $len; $i++) {
        if (!isset($arr_n[$i])) {
            break;
        }

        if ($arr_n[$i] !== $arr_h[$i]) {
            return false;
        }
    }

    return true;
}
