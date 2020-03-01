<?php

    /*
    This function will take in any string, and then split it into an array
    containing the words of the string. The words will be seperated by one
    or more spaces.
    
    We start by trimming the string to remove any leading or ending
    whitespace. If we are left with an empty string, we will return 0.
    
    By using preg_split, we can set a pattern that the function will use to
    split the remainding string. The pattern is written between two '/'
    characters. 
    
    Since we know the words in our string will be
    seperated by spaces, we can match each ' ' with the predefined character
    range [[:space]]. Using /[[:space:]]/ as our pattern, given an input of 
    "Hello    World" we recieve an output of:
    
    Array
    (
        [0] => Hello
        [1] => 
        [2] => 
        [3] => 
        [4] => World
    )
    
    which, while spliting our string with spaces, is not entirely the output we
    want, because of the empty elements in the array. This occurs because
    when our function comes across a 2nds space, it sees the empty string
    between the spaces as another word. To prevent this, we update the pattern
    by adding a '+' after the [[:space:]] to let in know that we accept 
    one or more spaces as a delimiter.
    
    We can use this function by including this file in any other php file.
    For example:
    
    include("ft_split.php");
    print_r(ft_split("Hello    World"));
    
    */
    function ft_split($str)
    {
        $str = trim($str);
        if ($str == '')
            return 0;
        $arr = preg_split("/[[:space:]]+/", $str);
        return $arr;
    }
?>