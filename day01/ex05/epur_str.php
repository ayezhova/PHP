#!/usr/bin/php
<?php
  /*
    In this excercise, we take a string with various white space and reprint
    the string with only a single space between the words.
    
    We are only taking in one string as an argument, so if our program recieves
    more than one or no arguments, we will print nothing. If after trimming the
    string we are left with an empty string, we will just print an empty line.
    
    Our plan will be to use preg_split to seperate the string into an array 
    with each entry as a single word. In C, we'd then print it one entry at a time,
    with a space between them. Luckily, in PHP we can use the implode function
    to combine the elements in the array, using " " as the glue.
    
    For the ft_split_whitespace function, we use a variation of the earlier
    ft_split from ex03. For ft_split, we assumed that the only whitespace would
    be spaces. Now, spaces, tabs and newline are all viable, so we will need to
    change the pattern in the preg_split function. In this case, we can use '\s'
    to match any whitespace characters.
  */
    function ft_split_whitespace($str)
    {
        $str = trim($str);
        if ($str == '')
            return 0;
        $arr = preg_split("/\s+/", $str);
        return $arr;
    }
  
    if ($argc == 2)
    {
        $word_arr = ft_split_whitespace($argv[1]);
        if ($word_arr !== 0)
            echo implode(" ", $word_arr);
        echo "\n";
        return;
    }
?>