<?php
    require_once 'ShipH.Class.php';
    require_once 'Rock.Class.php';
    session_start();
    
    
    //remove from lobby
    if(file_exists("../private/in_lobby"))
    {
      $fd = fopen("../private/in_lobby", "c+");
      flock($fd, LOCK_SH);
      $in_lobby = unserialize(file_get_contents("../private/in_lobby"));
      flock($fd, LOCK_UN);
    }
    if (in_array($_SESSION["logged_on_user"], $in_lobby))
    {
      $index = array_search($_SESSION["logged_on_user"], $in_lobby);
      if ($index !== FALSE)
      {
        unset($in_lobby[$index]);
        flock($fd, LOCK_EX);
        file_put_contents("../private/in_lobby", serialize($in_lobby));
        flock($fd, LOCK_UN);
      }
    }
    
    //add to this game
    if(!file_exists("../private/in_game"))
    {
        $in_game = array();
        $fd = fopen("../private/in_game", "c+");
    }
    else
    {
        $fd = fopen("../private/in_game", "c+");
        flock($fd, LOCK_SH);
        $in_game = unserialize(file_get_contents("../private/in_game"));
        flock($fd, LOCK_UN);
    }
    if (!in_array($_SESSION["logged_on_user"], $in_game))
    {
        $in_game[] = $_SESSION["logged_on_user"];
        flock($fd, LOCK_EX);
        file_put_contents("../private/in_game", serialize($in_game));
        flock($fd, LOCK_UN);
    }
    fclose($fd);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Good Game</title>
    </head>
    <body>
        <?php
            define("WIDTH", 800);
            define("HEIGHT", 500);
            //Make a spaceship object.
            $ship = new ShipH(array('name'=>"Cool Ship", 'img_url' => "resources/triang.png", 'x'=>rand(0, WIDTH), 'y'=>rand(0, HEIGHT), 'bullet'=>8));
            $rock = new Rock(array('size' => 15, 'damage' => 19));
        ?>
        <img id="ship_img" src="<?php echo $ship->get_img(); ?>" height="100" width="30" style="display:none"/>
        <img id="rock_img" src="<?php echo $rock->get_img(); ?>" height="30" width="30" style="display:none"/>
        <canvas id="gameCanvas" width="<?php echo WIDTH; ?>" height="<?php echo HEIGHT; ?>">
        </canvas>
        <script>
            <?php 
                define(FPS, 10);
                define(SHIP_SIZE, 30);
                define(TURN_SPEED, 200); //turn speed in deg / second
                define(SHIP_ACC, 5); // acceleration of the ship in px per s per s
                define(FRICTION, 0.7); //slow down ship
                
                $x = $ship->position['x'];
                $y = $ship->position['y'];
                $r = SHIP_SIZE / 2;
                $a = 90 / 180 * M_PI;
                $rot = $a;
                $moving = FALSE;
                $move_x = 0;
                $move_y = 0;
            ?>
            
            /** @type {HTMLCanvasElement} */
            var canv = document.getElementById("gameCanvas");
            var context = canv.getContext("2d");
            
            var ship_img = document.getElementById("ship_img");
            var rock_img = document.getElementById("rock_img");
            
            var moving = false;
            
            context.drawImage(rock_img, 0, 10, 100, 100 );
            
            //set up event handlers
            document.addEventListener("keydown", keyDown);
            document.addEventListener("keyup", keyUp);
            
            //will call update function
            setInterval(update, 1000 / <?php echo FPS; ?>);
            
            function keyDown(/** @type {KeyboardEvent} */ ev)
            {
                switch(ev.keyCode)
                {
                    case 37: //left arrow - rotate ship left
                        <?php $rot = - TURN_SPEED / 180 * M_PI / FPS; ?> // rotation in radians devided by the frame rate
                        break;
                    case 38: //up arrow - move forward
                        <?php $moving = TRUE; ?>
                        moving = true;
                        break;
                    case 39: //right arrow - rotate ship right
                        <?php $rot = + TURN_SPEED / 180 * M_PI / FPS; ?> // rotation in radians devided by the frame rate
                        break;
                }
            }
            
            function keyUp(/** @type {KeyboardEvent} */ ev)
            {
                switch(ev.keyCode)
                {
                    case 37: //left arrow - stop rotating left
                        <?php $rot = 0; ?>
                        break;
                    case 38: //up arrow - stop moving forward
                        <?php $moving = FALSE; ?>
                        moving = false;
                        break;
                    case 39: //right arrow - stop rotating right
                        <?php $rot = 0; ?>
                        break;
                }
            }
            
            function update()
            {
                //draw background
                context.fillStyle = "black";
                context.fillRect(0, 0, canv.width, canv.height);
                
                //move ship
                if (moving)
                {
                    <?php
                        $move_x += SHIP_ACC * cos($a) / FPS;
                        $move_y -= SHIP_ACC * sin($a) / FPS;
                    ?>
                }
                else
                {
                    <?php
                        $move_x += FRICTION * $move_x / FPS;
                        $move_y -= FRICTION * $move_y / FPS;
                    ?>
                }
                
                rotateAndPaintImage(context, ship_img, <?php echo $a; ?>,  <?php echo $x; ?>, <?php echo $y; ?>, 15, 15);
                function rotateAndPaintImage (cnxt, image, angleInRad , positionX, positionY, axisX, axisY ) {
                    console.log(positionX);
                    cnxt.translate( positionX, positionY );
                    cnxt.rotate( angleInRad );
                    cnxt.drawImage( image, -axisX, -axisY, 30, 30 );
                    cnxt.rotate( -angleInRad );
                    cnxt.translate( -positionX, -positionY );
                }
                
                context.drawImage(rock_img, 50, 100, 50, 50 );
                
                
                //rotate ship
                <?php $a -= $rot; ?>
                    //ship.a -= ship.rot;
                //move ship
                 
                <?php
                
                $x -= $move_x;
                $y =+ $move_y;
                ?>
                //ship.x -= ship.move.x;
                //ship.y += ship.move.y;
                
                //handle edge of screen
                <?php
                if ($x < 0 - $r)
                    $x = WIDTH + $r;
                else if ($x > WIDTH + $r)
                    $x = -$r;
                if ($y < 0 - $r)
                    $y = HEIGHT + $r;
                else if ($y > HEIGHT + $r)
                    $y = -$r;
                ?>
                /*
                if (ship.x < 0 - ship.r)
                    ship.x = canv.width + ship.r;
                else if (ship.x > canv.width + ship.r)
                    ship.x = -ship.r;
                if (ship.y < 0 - ship.r)
                    ship.y = canv.height + ship.r;
                else if (ship.y > canv.height + ship.r)
                    ship.y = -ship.r; */
                
                <?php echo "console.log(\"test\")"?>
                //write location into file
                /*
                var file = new File("../private/ship_location");
                var fd = fopen("../private/ship_location");
                if(!file.exists())
                {
                    var location = [];
                }
                else
                {
                    flock($fd, LOCK_SH);
                    $location = unserialize(fread("../private/ship_location"));
                    flock($fd, LOCK_UN);
                }
                $in_lobby[$_SESSION["logged_on_user"]] = array('x'=>ship.x, 'y'=>ship.y);
                flock($fd, LOCK_EX);
                file_put_contents("../private/in_lobby", serialize($in_lobby));
                flock($fd, LOCK_UN);
                fclose($fd); */
                /* 
                //center dot - debugging
                context.fillStyle = 'red';
                context.fillRect(ship.x - 1, ship.y - 1, 2, 2); */
            }
        </script>
        <!-- <iframe name="load_players" src="load_players.php" width="100%" height="0px" style="border:none;"></iframe>
        -->
        <br>
        <a href="../login/logout.php" style="color:blue">You are logged in as <i><?php echo $_SESSION["logged_on_user"] ?></i>. Click here to logout.</a>
    </body>
</html>