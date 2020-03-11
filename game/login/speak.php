<?php
  session_start();
  date_default_timezone_set("America/Los_Angeles");

  if ($_POST["msg"] && $_POST["submit"] && $_POST["submit"] == "OK")
  {
    if ($_SESSION["logged_on_user"] && $_SESSION["logged_on_user"] !== "")
    {
      $message = array('login'=>$_SESSION["logged_on_user"], 'time' =>time(), 'msg'=>$_POST["msg"]);
      if (!file_exists("../private/chat"))
      {
        $chatarray = array();
        $fd = fopen("../private/chat", "c+");
      }
      else
      {
        $fd = fopen("../private/chat", "c+");
        flock($fd, LOCK_SH);
        $chatarray = unserialize(file_get_contents("../private/chat"));
        flock($fd, LOCK_UN);
      }
      $chatarray[] = $message;
      flock($fd, LOCK_EX);
      file_put_contents("../private/chat", serialize($chatarray));
      flock($fd, LOCK_UN);
      fclose($fd);
	}
	else
	{
		echo "ERROR\n";
	}
}
?>
<style>
input
{
  font-size: 16px;
}
</style>
<html>
 <head>
   <meta charset=“UTF-8””>
   <script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
</head>
 <body style="color:white">
   <form name="speak.php" method="post" action="speak.php">
     Message: <input type="text" name="msg" value="" size="85"/>
     <input type="submit" name="submit" value="OK" />
   </form>
 </body>
</html>
