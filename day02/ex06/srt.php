#!/usr/bin/php
<?php
    function double_array_sort($arr1, $arr2)
    {
        if ($arr1[1] > $arr2[1])
            return 1;
        return -1;
    }

    if ($argc !== 2 || file_exists($argv[1]) === FALSE)
        return;
    $srt_file = file($argv[1]);
    $time_array = array_chunk($srt_file, 4);
    usort($time_array, "double_array_sort");
    $i = 1;
    $first = 0;
    foreach ($time_array as $block)
    {
        if ($first++ !== 0)
            echo "\n";
        echo $i . "\n";
        echo $block[1];
        echo $block[2];
        $i++;
    }
?>