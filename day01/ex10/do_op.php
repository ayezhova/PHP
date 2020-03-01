#!/usr/bin/php
<?php
    function check_args($args)
    {
        $options = "%*-+/";
        
        if (is_numeric($args[1]) === false or is_numeric($args[3]) === false)
            return 0;
        if (strlen($args[2]) !== 1 or strpos($options, $args[2]) === false)
            return 0;
        return 1;
    }

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

    //We can use array map to apply a function to all elements in an array.
    //Here we use it to remove all whitespace from left and right.
    $calc = array_map("trim", $argv);
    if ($argc !== 4 || check_args($calc) !== 1)
    {
        echo "Incorrect Parameters\n";
        return;
    }
    else
    {
        //removing unneeded first element (name of exe)
        array_shift($calc);
        do_op($calc);
    }
?>