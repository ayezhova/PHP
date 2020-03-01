#!/usr/bin/php
<?php
    function do_op($calc)
    {
        switch ($calc[1])
        {
            case "*":
                echo $calc[0] * $calc[2];
                break;
            case "%":
                echo $calc[0] % $calc[2];
                break;
            case "/":
                echo $calc[0] / $calc[2];
                break;
            case "+":
                echo $calc[0] + $calc[2];
                break;
            case "-":
                echo $calc[0] - $calc[2];
                break;
        }
        echo "\n";
    }

    function skip_spaces($i, $str)
    {
        while ($i < strlen($str) && $str[$i] == ' ')
            $i++;
        return $i;
    }
    
    function check_arg($str)
    {
        $i = 0;
        $arr = array();
        $options = "%*-+/";
        
        $str = trim($str);
        if (strlen($str) == 0 || preg_match("/[a-zA-Z]/", $str) !== 0)
            return false;
        $arr[] = intval($str);
        if ($arr[0] == 0 && $str[0] !== '0')
            return false;
        while ($i < strlen($str) && is_numeric($str[$i]))
            $i++;
        $i = skip_spaces($i, $str);
        if (strpos($options, $str[$i]) === false)
            return false;
        $arr[] = $options[strpos($options, $str[$i])];
        $i++;
        $i = skip_spaces($i, $str);
        $str = substr($str, $i);
        if (is_numeric($str) === false)
            return false;
        $arr[] = intval($str);
        return $arr;
    }

    if ($argc !== 2)
    {
        echo "Incorrect Parameters\n";
        return;
    }
    $calc = check_arg($argv[1]);
    if ($calc === false)
    {
        echo "Syntax Error\n";
        return;
    }
    do_op($calc);
?>