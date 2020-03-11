Loading...

<?php
    session_start();
    if(!file_exists("../private/loading"))
    {
        $loading = array();
        $fd = fopen("../private/loading", "c+");
    }
    else
    {
        $fd = fopen("../private/loading", "c+");
        flock($fd, LOCK_SH);
        $loading = unserialize(file_get_contents("../private/loading"));
        flock($fd, LOCK_UN);
    }
    if (!in_array($_SESSION["logged_on_user"], $loading))
    {
        $loading[] = $_SESSION["logged_on_user"];
        flock($fd, LOCK_EX);
        file_put_contents("../private/loading", serialize($loading));
        flock($fd, LOCK_UN);
    }
    fclose($fd);
    
    if(file_exists("../private/request"))
    {
        $fd = fopen("../private/request", "c+");
        flock($fd, LOCK_SH);
        $requested = unserialize(file_get_contents("../private/request"));
        flock($fd, LOCK_UN);
    }
    if (in_array($_SESSION["logged_on_user"], $requested))
    {
        $index = array_search($_SESSION["logged_on_user"], $requested);
        unset($requested[$index]);
        flock($fd, LOCK_EX);
        file_put_contents("../private/request", serialize($requested));
        flock($fd, LOCK_UN);
    }
    fclose($fd);
?>

<html>
    <script>
        function changeURL( url ) {
            document.location = url;
        };
    </script>
    <iframe name="loader" src="loader.php" width="100%" height="300px" style="border:none;"></iframe>
</html>