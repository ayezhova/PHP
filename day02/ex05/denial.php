#!/usr/bin/php
<?php
    if ($argc != 3 || (file_exists($argv[1]) === FALSE))
        return;
    $fd = fopen($argv[1], "r");
    if ($fd === FALSE)
        return;
    $header = fgetcsv($fd, 0, ";");
    if ($header === FALSE)
        return;
    if (in_array($argv[2], $header) === FALSE)
        return;
    $last_name = array();
    $first_name = array();
    $mail = array();
    $IP = array();
    $psuedo = array();
    $index = array_search($argv[2], $header);
    $line = fgetcsv($fd, 0, ";");
    while (($line = fgetcsv($fd, 0, ";")) !== FALSE)
    {
        $last_name[$line[$index]] = $line[0];
        $first_name[$line[$index]] = $line[1];
        $mail[$line[$index]] = $line[2];
        $IP[$line[$index]] = $line[3];
        $psuedo[$line[$index]] = $line[4];
    }
    fclose($fd);
    echo "Enter a command: ";
    $input = trim(fgets(STDIN));
    while (! feof(STDIN))
    {
        try
        {
            eval($input);
        }
        catch(ParseError $p){
            echo $p . "\n";
        }
        echo "Enter a command: ";
        $input = trim(fgets(STDIN));
    }
    echo "\n";
?>