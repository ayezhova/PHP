<?php
  session_start();
  function check_admin($login)
  {
    if (file_exists("../private/passwd"))
    {
      $passarray = unserialize(file_get_contents("../private/passwd"));
      if (isset($passarray[$login]))
      {
        if ($passarray[$login]["admin"] === TRUE)
        {
          return TRUE;
        }
      }
    }
    return FALSE;
  }
?>
