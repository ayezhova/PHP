<?php
    require_once 'ShipH.Class.php';
    require_once 'Rock.Class.php';
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
            $ship = new ShipH(array('name'=>"Cool Ship", 'img_url' => "resources/triang.png", 'x'=>WIDTH/2, 'y'=>HEIGHT/2, 'bullet'=>8));
            $rock = new Rock(array('size' => 15, 'damage' => 19));

        ?>
        <img id="ship_img" src="<?php echo $ship->get_img(); ?>" height="100" width="30" style="display:none"/>
        <img id="rock_img" src="<?php echo $rock->get_img(); ?>" height="30" width="30" style="display:none"/>
        <canvas id="gameCanvas" width="<?php echo WIDTH; ?>" height="<?php echo HEIGHT; ?>">
        </canvas>
        <script>
            const FPS = 30;
            const SHIP_SIZE = 30;
            const TURN_SPEED = 200 //turn speed in deg / second
            const SHIP_ACC = 5; // acceleration of the ship in px per s per s
            const FRICTION = 0.7; //slow down ship
            
            /** @type {HTMLCanvasElement} */
            var canv = document.getElementById("gameCanvas");
            var context = canv.getContext("2d");
            
            var ship = {
                x: <?php echo $ship->position['x'] ?>,
                y: <?php echo $ship->position['y'] ?>,
                r: SHIP_SIZE / 2,
                a: 90 / 180 * Math.PI, //angle convert to radians
                rot: 0, //rotation
                moving: false,
                move:
                {
                    x: 0,
                    y: 0
                }
            }
            
            var ship_img = document.getElementById("ship_img");
            var rock_img = document.getElementById("rock_img");
            
            context.drawImage(rock_img, 0, 10, 100, 100 );
            
            //set up event handlers
            document.addEventListener("keydown", keyDown);
            document.addEventListener("keyup", keyUp);
            
            //will call update function
            setInterval(update, 1000 / FPS);
            
            function keyDown(/** @type {KeyboardEvent} */ ev)
            {
                switch(ev.keyCode)
                {
                    case 37: //left arrow - rotate ship left
                        ship.rot = - TURN_SPEED / 180 * Math.PI / FPS; // rotation in radians devided by the frame rate
                        break;
                    case 38: //up arrow - move forward
                        ship.moving = true;
                        break;
                    case 39: //right arrow - rotate ship right
                        ship.rot = + TURN_SPEED / 180 * Math.PI / FPS; // rotation in radians devided by the frame rate
                        break;
                }
            }
            
            function keyUp(/** @type {KeyboardEvent} */ ev)
            {
                switch(ev.keyCode)
                {
                    case 37: //left arrow - stop rotating left
                        ship.rot = 0;
                        break;
                    case 38: //up arrow - stop moving forward
                        ship.moving = false;
                        break;
                    case 39: //right arrow - stop rotating right
                        ship.rot = 0;
                        break;
                }
            }
            
            function update()
            {
                //draw background
                context.fillStyle = "black";
                context.fillRect(0, 0, canv.width, canv.height);
                
                //move ship
                if (ship.moving)
                {
                    ship.move.x += SHIP_ACC * Math.cos(ship.a) / FPS;
                    ship.move.y -= SHIP_ACC * Math.sin(ship.a) / FPS;
                }
                else
                {
                    ship.move.x -= FRICTION * ship.move.x / FPS;
                    ship.move.y -= FRICTION * ship.move.y / FPS;
                }
                
                rotateAndPaintImage(context, ship_img, ship.a, ship.x, ship.y, 15, 15);
                function rotateAndPaintImage (cnxt, image, angleInRad , positionX, positionY, axisX, axisY ) {
                    cnxt.translate( positionX, positionY );
                    cnxt.rotate( angleInRad );
                    cnxt.drawImage( image, -axisX, -axisY, 30, 30 );
                    cnxt.rotate( -angleInRad );
                    cnxt.translate( -positionX, -positionY );
                }
                
                context.drawImage(rock_img, 50, 100, 50, 50 );
                
                if(ship.x == 50 && ship.y == 100)
                    alert("You lose!");
                
                //rotate ship
                    ship.a -= ship.rot;
                //move ship
                    ship.x -= ship.move.x;
                    ship.y += ship.move.y;
                
                //handle edge of screen
                if (ship.x < 0 - ship.r)
                    ship.x = canv.width + ship.r;
                else if (ship.x > canv.width + ship.r)
                    ship.x = -ship.r;
                if (ship.y < 0 - ship.r)
                    ship.y = canv.height + ship.r;
                else if (ship.y > canv.height + ship.r)
                    ship.y = -ship.r; 
                
                /* 
                //center dot - debugging
                context.fillStyle = 'red';
                context.fillRect(ship.x - 1, ship.y - 1, 2, 2); */
            }
        </script>
    </body>
</html>