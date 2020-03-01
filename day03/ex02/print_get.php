<?php
    foreach($_GET as $key=>$value)
    {
        if ($value === "")
            echo $key . PHP_EOL;
        else
            echo $key . ": " . $value . PHP_EOL;
    }
?>