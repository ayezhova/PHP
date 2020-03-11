<script>
      setInterval(function(){
        location.reload();
      }, 1000)
</script>

<?php
  session_start();

  if (file_exists("../private/chat"))
  {
    $fd = fopen("../private/chat", "r");
    flock($fd, LOCK_SH);
    $chatarray = unserialize(file_get_contents("../private/chat"));
    flock($fd, LOCK_UN);
?>
<style>
/*body
{
    background-image: url("chat_background.png");
    background-repeat: no-repeat;
    background-size: 100vw 100vh;
}*/
</style>
<html>
  <body style="color:white">
<?php
    foreach ($chatarray as $messageArray)
    {
      $charTime = date("[H:i]", $messageArray["time"]);
      $user = $messageArray['login'];
      $message = $messageArray["msg"];
      echo $charTime." "."<b>".$user."</b>".": ".$message."<br />";
	}
  }
?>
  </body>
</html>
