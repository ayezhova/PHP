<?php
    require_once 'ShipH.Class.php';

    echo "Using Reflection Classes to Debug Programs:\n";
    
    echo "Set up a reflection class.\n";
    $reflection = new ReflectionClass('ShipH');
    echo "Reflection's information on Parent of ShipH\n";
    echo "-----------------------------------------------\n";
    echo $reflection->getParentClass();
    echo "Testing Reflection's information on ShipH's variables\n";
    echo "-----------------------------------------------\n";
    print_r($reflection->getProperties(ReflectionProperty::IS_PUBLIC));
    echo "Reflection's information on Parent of ShipH\n";
    echo "-----------------------------------------------\n";
    echo $reflection->getParentClass();
    echo "\n\n\n";
    
    echo "Using Reflection to test private variables: \n";
    echo "-----------------------------------------------\n";
    echo "Usually when we try to access a private variable, we get an erorr message: \n";
    $ship = new ShipH(array('name'=>"Ship 1", 'img_url' => "url", 'x'=>6, 'y'=>9, 'bullet'=>8));
    $ship->_error;
    echo "\nUsing the reflection class to access the same variable:\n";
    $reflectionProp =  $reflection->getProperty('_error');
    $reflectionProp->setAccessible(true);
    echo "Value of private variable: " . $reflectionProp->getValue($ship) . "\n";
    
?>