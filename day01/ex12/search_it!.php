#!/usr/bin/php
<?php
    function get_arr($strs, $num)
    {
        $i = 2;
        $arr = array();
        while ($i < $num)
        {
            $semicolon = strpos($strs[$i], ":");
            if ($semicolon === false)
                return false;
            $arr[substr($strs[$i], 0, $semicolon)] = substr($strs[$i], $semicolon + 1);
            $i++;
        }
        return $arr;
    }

    if ($argc < 3)
        return;
    $find = $argv[1];
    $arr = get_arr($argv, $argc);
    if ($arr === false)
    {
        echo "Error with arguments\n";
        return;
    }
    if (array_key_exists($find, $arr))
        echo $arr[$find] . "\n";
?>