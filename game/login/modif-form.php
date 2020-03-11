<?php
  session_start();
  if (isset($_POST["submit"]) && $_POST["submit"]=== "OK")
  {
    if (!isset($_POST["login"]) || $_POST["login"]==="")
    {
      $_SESSION["error"] = 1;
      $_SESSION["usr_error"] = "usrn_error";
    }
    if (!isset($_POST["oldpw"]) || $_POST["oldpw"]==="")
    {
      $_SESSION["error"] = 1;
      $_SESSION["old_pwd_error"] = "old_pass_err";
    }
    if (!isset($_POST["newpw"]) || $_POST["newpw"]==="")
    {
      $_SESSION["error"] = 1;
      $_SESSION["new_pwd_error"] = 1;
    }
  }
  if (!isset($_SESSION["error"]))
  {
    if (file_exists("../private/passwd"))
    {
      $passarray = unserialize(file_get_contents("../private/passwd"));
      if (isset($passarray[$_POST["login"]]))
      {
        $element = $passarray[$_POST["login"]];
        if ($element["password"] === hash("whirlpool", $_POST["oldpw"]))
        {
          $passarray[$_POST["login"]]["password"] = hash("whirlpool", $_POST["newpw"]);

          file_put_contents("../private/passwd", serialize($passarray));
          echo "OK\n";
          header("Location: modif.php");
          return;
        }
        else
        {
          $_SESSION["old_pwd_error"] = "wrong_pass";
        }
      }
      else
      {
        $_SESSION["usr_error"] = "wrong_usr";
      }
    }
    else
    {
      $_SESSION["error"] = 1;
      $_SESSION["usr_error"] = "wrong_usr";
    }

  }
  else
  {
    header("Location: modif.php");
  }
  header("Location: modif.php");
?>
