<?php
  session_start();
?>
<html>
<head>
</head>
<body>
  <h2>Hello Admin</h2>
  Delete User Account:
  <form name="delete" action="ADMIN_delete_form.php" method="post">
    <select name="user_to_del">
      <?php
        $passarray = unserialize(file_get_contents("../private/passwd"));
        foreach ($passarray as $login=>$userArray)
        {
          if ($_SESSION["logged_on_user"] !== $login && $login !== "ADMIN")
            echo "<option value=".$login.">".$login."</option>";
        }
      ?>
    </select>
    <input type="submit" name="submit" value="OK" />
  </form>
  <br />
  Change User Email:
  <form name="user_email" action="ADMIN_update_email.php" method="post">
    <select name="user_email">
      <?php
        $passarray = unserialize(file_get_contents("../private/passwd"));
        foreach ($passarray as $login=>$userArray)
        {
          if ($_SESSION["logged_on_user"] !== $login)
            echo "<option value=".$login.">".$login."</option>";
        }
      ?>
    </select>
    <input type="email" name="email" value="" />
    <input type="submit" name="submit" value="OK" />
  </form>
  <br />
  Give a user ADMIN:
  <form name="user_admin" action="ADMIN_make_admin.php" method="post">
    <select name="admin_user">
      <?php
        $passarray = unserialize(file_get_contents("../private/passwd"));
        foreach ($passarray as $login=>$userArray)
        {
          if ($_SESSION["logged_on_user"] !== $login && $userArray["admin"]===FALSE)
            echo "<option value=".$login.">".$login."</option>";
        }
      ?>
    </select>
    <input type="submit" name="submit" value="OK" />
  </form>
  <br/>
  <a href="logout.php">Click here to log out!</a>
</body>
</html>
