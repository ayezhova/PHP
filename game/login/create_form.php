<?php
  session_start();

  echo "here";
  if (isset($_POST["submit"]) && $_POST["submit"]=== "OK")
  {
    if (!isset($_POST["login"]) || $_POST["login"]==="")
    {
      $_SESSION["error"] = 1;
      $_SESSION["usr_error"] = "usrn_error";
    }
    if (!isset($_POST["passwd"]) || $_POST["passwd"]==="")
    {
      $_SESSION["error"] = 1;
      $_SESSION["pwd_error"] = 1;
    }
    if (!isset($_POST["first_name"]) || $_POST["first_name"]==="")
    {
      $_SESSION["error"] = 1;
      $_SESSION["first_name_error"] = 1;
    }
    if (!isset($_POST["last_name"]) || $_POST["last_name"]==="")
    {
      $_SESSION["error"] = 1;
      $_SESSION["last_name_error"] = 1;
    }
    if (!isset($_POST["email"]) || $_POST["email"]==="" || !(strpos($_POST["email"], "@gmail.com") || strpos($_POST["email"], "@yahoo.com") || strpos($_POST["email"], "@outlook.com") || strpos($_POST["email"], "@inbox.com")))
    {
      $_SESSION["error"] = 1;
      $_SESSION["email_error"] = 1;
    }
  }
  else
  {
    $_SESSION["error"] = 1;
    $_SESSION["session_error"] = 1;
  }
  if (!isset($_SESSION["error"]))
  {
    if (file_exists("../private/passwd"))
    {
      $passarray = unserialize(file_get_contents("../private/passwd"));
    }
    else
    {
      $passarray = array();
      file_put_contents("../private/passwd", serialize($passarray));
    }
    if (isset($passarray[$_POST["login"]]))
    {
      $_SESSION["usr_error"] ="usr_taken";
      header("Location: create.php");
      return;
    }
    $newuser = array();
    $newuser["first_name"] = $_POST["first_name"];
    $newuser["last_name"] = $_POST["last_name"];
    $newuser["email"] = $_POST["email"];
    $newuser["newsletter"] = $_POST["newsletter"];
    $newuser["password"] = hash("whirlpool", $_POST["passwd"]);
    $newuser["admin"] = FALSE;
    $passarray[$_POST["login"]] = $newuser;
    file_put_contents("../private/passwd", serialize($passarray));
    echo "OK\n";
    header("Location: create.php");
    return;
  }
  header("Location: create.php");

?>
