<?php
  session_start();
  
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
  
  $_SESSION["logged_on_user"] = "";
  header("Location: index.php");
?>
