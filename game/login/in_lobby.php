
<script>
      setInterval(function(){
        location.reload();
      }, 10000);
      
      function changeURL( url ) {
          document.location = url;
        };
      
</script>

<?php
    session_start();
    
    $fd = fopen("../private/in_lobby", "c+");
    flock($fd, LOCK_SH);
    $in_lobby = unserialize(file_get_contents("../private/in_lobby"));
    flock($fd, LOCK_UN);
    fclose($fd);
    
    foreach ($in_lobby as $player)
    {
      if ($player != $_SESSION["logged_on_user"])
        echo "<h3><a target=\"_parent\" href=\"?link=" . $player . "\" style=\"color:white\">" . $player ."</a></h3>\n";        
    }
    
    if(file_exists("../private/request"))
    {
        $fd = fopen("../private/loading", "c+");
        flock($fd, LOCK_SH);
        $requested = unserialize(file_get_contents("../private/request"));
        flock($fd, LOCK_UN);
        fclose($fd);
        if (in_array($_SESSION["logged_on_user"], $requested))
            echo "<script>parent.changeURL('loading_screen.php');</script>";
    }
    
    $link = $_GET['link'];
    if($link)
    {
        if(!file_exists("../private/request"))
        {
            $request = array();
            $fd = fopen("../private/request", "c+");
        }
        else
        {
            $fd = fopen("../private/request", "c+");
            flock($fd, LOCK_SH);
            $request = unserialize(file_get_contents("../private/request"));
            flock($fd, LOCK_UN);
        }
        if (!in_array($_GET['link'], $request))
        {
            $request[] = $_GET['link'];
            flock($fd, LOCK_EX);
            file_put_contents("../private/request", serialize($request));
            flock($fd, LOCK_UN);
        }
        fclose($fd);
        echo "<script>parent.changeURL('loading_screen.php');</script>";
    }
?>
