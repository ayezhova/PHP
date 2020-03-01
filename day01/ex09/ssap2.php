#!/usr/bin/php
<?php
/*
    In this program, we are given one or more strings as arguments, and we need
    to print all the words, defined as characters between whitespace, and will
    reprint them in a specific order. The order is case insensitive, 
    alphabetical order first, then numbers, then all other characters, each in
    ASCII order.
    
    The plan will be similar to the previous ex06 which sorted the word order
    as well, but in this exercise we will use a custom sort. We'll walk through
    the function until we find a character where the two string do not match.
    There, we will first find whether the character fits into the alphabetical,
    numerical or other category. Since we know that if one is alphabetical, and
    the other is not, then the alphabetical is definitely first, we can send that
    return right away. Similiarly, if one is numerical and the other is neither
    alphabetical nor numerical, then the numerical is definitely first. Other
    these two situations, if the two fall into the same category, then we'll
    have the element with the lower ascii value go first. In a comparison
    function, we can take the difference between the ascii values to do so.
    To access the ascii values, we can use PHP's ord function. If both are 
    alphabetical, we'll have to convert the values to lowercase prior to finding
    the ascii to make sure we account for the case insensitivity.
    
*/
    
    function ft_split_whitespace($str)
    {
        $str = trim($str);
        if ($str == '')
            return 0;
        $arr = preg_split("/\s+/", $str);
        return $arr;
    }
    
    function check_case($char)
    {
        if (preg_match("/[a-zA-Z]/", $char))
            return "alpha";
        else if (preg_match("/[0-9]/", $char))
            return "num";
        return "other";
    }
    
    function custom_comp($str1, $str2)
    {        
        $i = 0;
        $size1 = strlen($str1);
        $size2 = strlen($str2);
        while ($i < $size1 && $i < $size2)
        {
            if ($str1[$i] !== $str2[$i])
            {
                $case1 = check_case($str1[$i]);
                $case2 = check_case($str2[$i]);
                //if one of the characters is alphabetical, and the other is not, then
                //the one that is alphabetical will come before.
                if (($case1 == "alpha" and $case2 !== "alpha") or ($case1 !== "alpha" and $case2 == "alpha"))
                    return ($case1 == "alpha") ? -1 : 1;
                //if one of the characters is numerical, and the other is not, then
                //the one that is numerical will come before.
                if (($case1 == "num" and $case2 !== "num") or ($case1 !== "num" and $case2 == "num"))
                    return ($case1 == "num") ? -1 : 1;
                //if both are alpha, we have a special case, because we are
                //considering the values as case insensitive
                if ($case1 == "alpha" && $case2 == "alpha")
                    return ord(strtolower($str1[$i])) - ord(strtolower($str2[$i]));
                //otherwise, we can just return the ascii difference between
                //the two characters
                return ord($str1[$i]) - ord($str2[$i]);
            }
            $i++;
        }
        if ($size1 < $size2)
            return -1;
        return 1;
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
        usort($combined_array, "custom_comp");
        foreach($combined_array as $word)
            echo $word . "\n";
    }
?>