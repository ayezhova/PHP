<?php
  session_start();
  $errorstyle = '"outline: 2px solid red"';
  if (isset($_SESSION["error"]))
    unset($_SESSION["error"]);

?>

<style>

input
{
  margin: 5px;
}

</style>

<html>
  <head>
  </head>
  <body style="color: white">
    <h3>Are you sure you want to delete your accout?</h3>
    <form name="delete_form.php" action="delete_form.php" method="post">
      Username: <input type="text" name="login" value="" <?php if (isset($_SESSION["usr_error"])) echo "style=".$errorstyle; ?>/>
      <?php
      if (isset($_SESSION["usr_error"]))
      {
        if ($_SESSION["usr_error"] === "wrong_usr")
        {
          echo "This username is not in our database!";
        }
        else if ($_SESSION["usr_error"] === "usrn_error")
          echo "Username Error!";
        unset($_SESSION["usr_error"]);
      }
      ?>
      <br />
      Password: <input type="password" name="oldpw" value="" <?php if (isset($_SESSION["old_pwd_error"])) echo "style=".$errorstyle; ?>/>
      <?php
      if (isset($_SESSION["old_pwd_error"]))
      {
        if ($_SESSION["old_pwd_error"] === "wrong_pass")
        {
          echo "Incorrect Password for this username!";
        }
        else if ($_SESSION["old_pwd_error"] === "old_pass_err")
          echo "Password Error!";
        unset($_SESSION["old_pwd_error"]);
      }
      ?>
      <br/>
      <input type="submit" name="submit" value="Delete my account!" />
    </form>
  </body>
</html>
