#!/usr/bin/php
<?php
/*
    In this program, we are given one or more strings as arguments, and we need
    to print all the words, defined as characters between whitespace, and will
    reprint them in alphabetical order.
    
    The plan will be to split the arrays into words using ft_split_whitespace,
    combine them with array_merge, sort them in alphabetical order, and print
    the new array word by word. We can use safely use array_merge without
    overwriting any of our values, because ft_split_whitespace using numerical
    keys, so the new values will be appended, and will not overwrite existing
    values.
    
*/
    
    function ft_split_whitespace($str)
    {
        $str = trim($str);
        if ($str == '')
            return 0;
        $arr = preg_split("/\s+/", $str);
        return $arr;
    }
    
    if ($argc > 1)
    {
        $i = 1;
        $combined_array = array();
        while($i < $argc)
        {
            $temp_array = ft_split_whitespace($argv[$i]);
            if ($temp_array !== 0)
                $combined_array = array_merge($combined_array, $temp_array);
            $i++;
        }
        sort($combined_array);
        foreach($combined_array as $word)
            echo $word . "\n";
    }
?>