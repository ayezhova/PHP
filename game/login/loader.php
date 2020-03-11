<script>
    setInterval(function(){
        location.reload();
    }, 1000);
</script>

<?php
    if(file_exists("../private/loading"))
    {
        $fd = fopen("../private/loading", "c+");
        flock($fd, LOCK_SH);
        $loading = unserialize(file_get_contents("../private/loading"));
        flock($fd, LOCK_UN);
        fclose($fd);
        if (count($loading) == 2)
        {
            echo "<script>parent.changeURL('../game/index.php');</script>";
        }
    }
    
?>