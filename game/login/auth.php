<?php
  session_start();
  function auth($login, $passwd)
  {
    if (file_exists("../private/passwd"))
    {
      $passarray = unserialize(file_get_contents("../private/passwd"));
      if ($passarray[$login])
      {
        if ($passarray[$login]["password"] === hash("whirlpool", $passwd))
        {
          return TRUE;
        }
      }
    }
    return FALSE;
  }
?>
