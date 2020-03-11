<?php
  session_start();
  include 'check_admin.php';

  if (check_admin($_SESSION["logged_on_user"]) === TRUE)
  {
    $passarray = unserialize(file_get_contents("../private/passwd"));
    $passarray[$_POST["admin_user"]]["admin"] = TRUE;
    file_put_contents("../private/passwd", serialize($passarray));
    header("Location: admin_page.php");
  }
?>
