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
            const FPS = 20;
            const SHIP_SIZE = 30;
            const TURN_SPEED = 200 //turn speed in deg / second
            const SHIP_ACC = 5; // acceleration of the ship in px per s per s
            const SHIP_EXPLODE_DURATION = 0.3; //Duration of explosion
            const FRICTION = 0.7; //slow down ship
            const ASTEROID_NUM = 3; //starting number of asteroids
            const ASTEROID_SIZE = 80; //starting size of asteroids in px
            const ASTEROID_SPEED = 80; //max starting speed of asteroids in px/sec
            const SHOW_CIRCLE = false; //show collision circle
            const LASER_MAX = 10; //max # lasers on screen
            const LASER_SPEED = 500; //speed lasers px/sec
            
            /** @type {HTMLCanvasElement} */
            var canv = document.getElementById("gameCanvas");
            var context = canv.getContext("2d");
            
            var ship = newShip();
            
            function newShip() {
                return {
                    x: <?php echo $ship->position['x'] ?>,
                    y: <?php echo $ship->position['y'] ?>,
                    r: SHIP_SIZE / 2,
                    a: 90 / 180 * Math.PI, //angle convert to radians
                    rot: 0, //rotation
                    moving: false,
                    lasers: [],
                    explodeTime: 0,
                    canShoot: true,
                    move:
                    {
                        x: 0,
                        y: 0
                    }
                }
            }
            
            function shootLaser()
            {
                //create laser
                if (ship.canShoot && ship.lasers.length < LASER_MAX)
                {
                    ship.lasers.push({ //shooting from nose of ship
                        x: ship.x + 4 / 3 * ship.r * Math.cos(ship.a),
                        y: ship.y - 4 / 3 * ship.r * Math.sin(ship.a),
                        xv: - LASER_SPEED * Math.cos(ship.a) / FPS,
                        yv: - LASER_SPEED * Math.sin(ship.a) / FPS,
                    });
                }
                
                //prevent further shooting
                ship.canShoot = false;
            }
            
            //set up asteroid
            var astroids = [];
            
            createAsteroidBelt();
            
            function createAsteroidBelt()
            {
                asteroids = [];
                var x, y;
                for (var i = 0; i < ASTEROID_NUM; i++)
                {
                    do {
                        x = Math.floor(Math.random() * canv.width);
                        y = Math.floor(Math.random() * canv.height);
                    } while (distBetweenPoints(ship.x, ship.y, x, y) < ASTEROID_SIZE * 2 + ship.r)
                    
                    asteroids.push(newAsteroid(x, y));
                }
            }
            
            function distBetweenPoints(x1, y1, x2, y2)
            {
                return Math.sqrt(Math.pow(x2-x1, 2) + Math.pow(y2-y1, 2));
            }
            
            function newAsteroid(x, y)
            {
                var aster = {
                    x: x,
                    y: y,
                    xv: Math.random() * ASTEROID_SPEED / FPS * (Math.random() < 0.5 ? 1 : -1),
                    yv: Math.random() * ASTEROID_SPEED / FPS * (Math.random() < 0.5 ? 1 : -1),
                    size: Math.floor(Math.random() * (ASTEROID_SIZE - 30)) + 20,
                    a: Math.random() * Math.PI  * 2 //in radians
                };
                return aster;
            }
            
            
            var ship_img = document.getElementById("ship_img");
            var rock_img = document.getElementById("rock_img");
            
            //set up event handlers
            document.addEventListener("keydown", keyDown);
            document.addEventListener("keyup", keyUp);
            
            //will call update function
            setInterval(update, 1000 / FPS);
            
            function keyDown(/** @type {KeyboardEvent} */ ev)
            {
                switch(ev.keyCode)
                {
                    case 32: //spacebar - shoot laser
                        shootLaser();
                        break;
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
                    case 32: //spacebar - allow shooting
                        ship.canShoot = true;
                        break;
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
                var exploding = ship.explodeTime > 0; //ship is exploding
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
                
                //draw ship
                if (!exploding)
                    rotateAndPaintImage(context, ship_img, ship.a, ship.x, ship.y, 15, 15);
                else
                {
                    //draw explosions
                    context.fillStyle = "darkred";
                    context.beginPath();
                    context.arc(ship.x, ship.y, ship.r * 1.7, 0, Math.PI * 2, false);
                    context.fill();
                    context.fillStyle = "red";
                    context.beginPath();
                    context.arc(ship.x, ship.y, ship.r * 1.4, 0, Math.PI * 2, false);
                    context.fill();
                    context.fillStyle = "orange";
                    context.beginPath();
                    context.arc(ship.x, ship.y, ship.r * 1.1, 0, Math.PI * 2, false);
                    context.fill();
                    context.fillStyle = "yellow";
                    context.beginPath();
                    context.arc(ship.x, ship.y, ship.r * 0.8, 0, Math.PI * 2, false);
                    context.fill();
                    context.fillStyle = "white";
                    context.beginPath();
                    context.arc(ship.x, ship.y, ship.r * 0.5, 0, Math.PI * 2, false);
                    context.fill();
                }
                
                if (SHOW_CIRCLE)
                {
                    context.strokeStyle = "red";
                    context.beginPath();
                    context.arc(ship.x, ship.y, ship.r, 0, Math.PI * 2, false);
                    context.stroke();
                }
                
                for (var i = 0; i < ship.lasers.length; i++)
                {
                    context.fillStyle = "salmon";
                    context.beginPath();
                    context.arc(ship.lasers[i].x, ship.lasers[i].y, SHIP_SIZE/15, 0, Math.PI * 2, false);
                    context.fill();
                    
                    //move lasers
                    ship.lasers[i].x += ship.lasers[i].xv;
                    ship.lasers[i].y += ship.lasers[i].yv;
                    if (ship.lasers[i].x < 0)
                        ship.lasers.splice(i, 1);
                    else if (ship.lasers[i].x > canv.width)
                        ship.lasers.splice(i, 1);
                    if (ship.lasers[i].y < 0)
                        ship.lasers.splice(i, 1);
                    else if (ship.lasers[i].y > canv.height)
                        ship.lasers.splice(i, 1);
                }
            
                
                for (var i = 0; i < asteroids.length; i++)
                {
                    //move the asteroids
                    asteroids[i].x += asteroids[i].xv;
                    asteroids[i].y += asteroids[i].yv;
                    
                    //draw asteroids
                    rotateAndPaintImage(context, rock_img, asteroids[i].a, asteroids[i].x, asteroids[i].y, asteroids[i].size, asteroids[i].size);
                
                    //handle off screen
                    if (asteroids[i].x < 0 - asteroids[i].size / 2)
                        asteroids[i].x = canv.width + asteroids[i].size / 2;
                    else if (asteroids[i].x > canv.width + asteroids[i].size / 2)
                        asteroids[i].x = -asteroids[i].size / 2;
                    if (asteroids[i].y < 0 - asteroids[i].size / 2)
                        asteroids[i].y = canv.height + asteroids[i].size / 2;
                    else if (asteroids[i].y > canv.height + asteroids[i].size / 2)
                        asteroids[i].y = -asteroids[i].size / 2;
                        
                    //show collision circle
                    if (SHOW_CIRCLE)
                    {
                        context.strokeStyle = "red";
                        context.beginPath();
                        context.arc(asteroids[i].x, asteroids[i].y, asteroids[i].size, 0, Math.PI * 2, false);
                        context.stroke();
                    }
                }
                
                //draw ship
                //rotateAndPaintImage(context, ship_img, ship.a, ship.x, ship.y, 15, 15);
        
                //check for asteroid collision
                for (var i = 0; i < asteroids.length; i++)
                {
                    if (distBetweenPoints(ship.x, ship.y, asteroids[i].x, asteroids[i].y) < ship.r + asteroids[i].size)
                    {
                        explodeShip();
                    }
                }
                
                function explodeShip()
                {
                    ship.canShoot = false;
                    ship.explodeTime = Math.ceil(SHIP_EXPLODE_DURATION * FPS);
                }
                
                function rotateAndPaintImage (cnxt, image, angleInRad , positionX, positionY, axisX, axisY ) {
                    cnxt.translate( positionX, positionY );
                    cnxt.rotate( angleInRad );
                    cnxt.drawImage( image, -axisX, -axisY, axisX * 2, axisY * 2 );
                    cnxt.rotate( -angleInRad );
                    cnxt.translate( -positionX, -positionY );
                }
                
                if (!exploding)
                {
                    //check for asteroid collision
                    for (var i = 0; i < asteroids.length; i++)
                    {
                        if (distBetweenPoints(ship.x, ship.y, asteroids[i].x, asteroids[i].y) < ship.r + asteroids[i].size)
                        {
                            explodeShip();
                        }
                    }
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
                }
                else
                {
                    ship.explodeTime--;
                    if (ship.explodeTime == 0)
                    {
                        ship = newShip();
                    }
                }
            }
        </script>
        <iframe name="load_players" src="load_players.php" width="100%" height="0px" style="border:none;"></iframe>
        <br>
        <a href="../login/logout.php" style="color:blue">You are logged in as <i><?php echo $_SESSION["logged_on_user"] ?></i>. Click here to logout.</a>
    </body>
</html>