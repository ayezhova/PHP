<?php
    require_once 'ShipH.Class.php';
    require_once 'Rock.Class.php';
    
    echo "Create rock correctly:\n";
    
    $rock_c = new Rock(array('size' => 15, 'damage' => 19));
    echo "Using trait get_img to get url: " . $rock_c->get_img() . PHP_EOL;
    
    echo "---------------------------------------------\n";
    echo "Create rock incorrectly:\n";
    
    $rock_i = new Rock(array('damage' => 19));
    
    echo "---------------------------------------------\n";
    echo "Creating ShipH Correctly:\n";
    
    $ship1 = new ShipH(array('name'=>"Ship 1", 'img_url' => "url", 'x'=>6, 'y'=>9, 'bullet'=>8));
    echo "Using trait get_img to get url: " . $ship1->get_img() . PHP_EOL;
    
    Spaceship::get_num_ships();
    
    Spaceship::$verbose = TRUE;
    $ship2 = new ShipH(array('name'=>"Ship 2", 'img_url' => "url", 'x'=>6, 'y'=>3, 'bullet'=>8));

    Spaceship::get_num_ships();
    
    echo "---------------------------------------------\n";
    echo "Creating Spaceship with missing param:\n";
    $shipIn = new ShipH(array('name'=>"Invalid spaceship", 'x'=>6, 'y'=>3, 'bullet'=>8));
    var_dump($shipIn);
    
    echo "---------------------------------------------\n";
    echo "Creating Spaceship with missing param:\n";
    $shipIn = new ShipH(array('name'=>"Invalid ShipH", 'x'=>6, 'y'=>3, 'bullet'=>8));
    var_dump($shipIn);
    
    echo "---------------------------------------------\n";
    echo "Call to function that does not exist\n";
    Spaceship::fake_function(6, 8);
    
    echo "---------------------------------------------\n";
    echo "Documents: \n";
    $ship1->spaceship_doc();
    $ship1->ship_doc();
    $rock_c->doc();
?>