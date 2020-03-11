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

<!DOCTYPE html>
<html>
  <head>
    <meta charset = "utf-8">
    <title>Session</title>
    <link
  </head>
  <body style="color: white">
    <form name="create_form.php" method="post" action="create_form.php">
      First Name: <input type="text" name="first_name" value="" <?php if (isset($_SESSION["first_name_error"]) && $_SESSION["first_name_error"] === 1) echo "style=".$errorstyle; ?>/> <?php if (isset($_SESSION["first_name_error"]) && $_SESSION["first_name_error"] === 1) echo "First Name Error!"; unset($_SESSION["first_name_error"]);?>
      <br />
      Last Name: <input type="text" name="last_name" value="" <?php if (isset($_SESSION["last_name_error"]) && $_SESSION["last_name_error"] === 1) echo "style=".$errorstyle; ?>/> <?php if (isset($_SESSION["last_name_error"]) && $_SESSION["last_name_error"] === 1) echo "Last Name Error!"; unset($_SESSION["last_name_error"]);?>
      <br />
      Email: <input type="email" name="email" value=""  <?php if (isset($_SESSION["email_error"]) && $_SESSION["email_error"] === 1) echo "style=".$errorstyle; ?>/> <?php if (isset($_SESSION["email_error"]) && $_SESSION["email_error"] === 1) echo "Please enter a valid email! We accept gmail, yahoo, outlook and inbox.com."; unset($_SESSION["email_error"]);?>
      <br />
      Username: <input type="text" name="login" value="" <?php if (isset($_SESSION["usr_error"])) echo "style=".$errorstyle; ?>/>
      <?php
      if (isset($_SESSION["usr_error"]))
      {
        if ($_SESSION["usr_error"] === "usr_taken")
        {
          echo "Sorry, user is taken!";
        }
        else if ($_SESSION["usr_error"] === "usrn_error")
          echo "Username Error!";
        unset($_SESSION["usr_error"]);
      }
      ?>
      <br />
      Password: <input type="password" name="passwd" value="" <?php if (isset($_SESSION["pwd_error"]) && $_SESSION["pwd_error"] === 1) echo "style=".$errorstyle; ?>/> <?php if (isset($_SESSION["pwd_error"]) && $_SESSION["pwd_error"] === 1) echo "Password Error!"; unset($_SESSION["pwd_error"]);?>
      <br />
      <input type="checkbox" name="newsletter"/> YES, I would like to recieve news updates!
      <br />
      <input type="submit" name="submit" value="OK" />
    </form>
  </body>
</html>
