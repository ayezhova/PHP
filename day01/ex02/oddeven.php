#!/usr/bin/php
<?php

    /*
    This program will check if the given input is odd or even. The function
    feof will check if the end of file has been reached. By reading from
    STDIN, we will be prompting the user on the command line. From the
    command line, the end of file will be 'CTRL-D'.
    */
    
    echo "Enter a number: ";
    $input = trim(fgets(STDIN));
    while (! feof(STDIN))
    {
        if (is_numeric($input))
        {
            echo "The number $input is ";
            if (intval($input) % 2 != 0)
                echo "odd";
            else
                echo "even";
        }
        else
            echo "'$input' is not a number";
        echo "\nEnter a number: ";
        $input = trim(fgets(STDIN));
    }
?>