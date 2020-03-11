<script>
     var loader = setInterval(function(){
        location.reload();
    }, 1000);
</script>

<?php
    if(file_exists("../private/in_game"))
    {
        $fd = fopen("../private/in_game", "c+");
        flock($fd, LOCK_SH);
        $in_game = unserialize(file_get_contents("../private/in_game"));
        flock($fd, LOCK_UN);
        fclose($fd);
        if (count($in_game) == 2)
        {
            $empty = array();
            if(file_exists("../private/loading"))
            {
                $fd = fopen("../private/loading", "c+");
                flock($fd, LOCK_EX);
                file_put_contents("../private/loading", serialize($empty));
                flock($fd, LOCK_UN);
                fclose($fd);
            }
            if(file_exists("../private/in_game"))
            {
                $fd = fopen("../private/in_game", "c+");
                flock($fd, LOCK_EX);
                file_put_contents("../private/in_game", serialize($empty));
                flock($fd, LOCK_UN);
                fclose($fd);
                if (count($loading) == 2)
                {
                    echo "<script>parent.changeURL('../game/in_game.php');</script>";
                }
            }
            echo "<script>clearInterval(loader);</script>";
        }
        if (count($in_game) == 0)
            echo "<script>clearInterval(loader);</script>";
    }
?>