#!/usr/bin/php
<?php
    function ft_split_whitespace($str)
    {
        $str = trim($str);
        if ($str == '')
            return 0;
        $arr = preg_split("/\s+/", $str);
        return $arr;
    }
  
    $first = 0;
    if ($argc > 1)
    {
        $word_arr = ft_split_whitespace($argv[1]);
        if ($word_arr !== 0)
        {
            $i = 0;
            foreach($word_arr as $word)
            {
                if ($i != 0)
                    echo $word . " ";
                $i++;
            }
            if ($i > 0)
                echo $word_arr[0];
        }
        echo "\n";
        return;
    }
?>