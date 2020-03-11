<script>
    var fd = fopen("../private/ship_location", 3);
    <?php
        $_SESSION["logged_on_user"] = "Person";
        $fd = fopen("../private/ship_location", "c+");
        flock($fd, LOCK_SH);
    ?>
    var location = JSON.parse(fread("../private/ship_location"));
    <?php 
        flock($fd, LOCK_UN);
        fclose($fd);
    ?>
    if (location === "")
        location = [];
    ship.x = 10;
    ship.y = 9;
    console.log(location);
    location[<?php echo $_SESSION["logged_on_user"]; ?>] = {x:ship.x, y:ship.y};
    console.log(location);
    <?php
        flock($fd, LOCK_EX);
    ?>
    fwrite("../private/in_lobby", JSON.stringify($in_lobby));
    <?php
        flock($fd, LOCK_UN);
        fclose($fd);
    ?>
    fclose(fd);
</script>
