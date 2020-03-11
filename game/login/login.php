<?php
  include 'auth.php';
  include 'check_admin.php';
  session_start();

  if (!$_POST["login"] || !$_POST["passwd"])
  {
    header("Location: index.php");
  }
  else
  {
    if (auth($_POST["login"], $_POST["passwd"]) === FALSE)
    {
        header("Location: index.php");
    }
    else
    {
      if (check_admin($_POST["login"]) === TRUE)
        header("Location: admin_page.php");
      
      $_SESSION["logged_on_user"] = $_POST["login"];
      if(!file_exists("../private/in_lobby"))
      {
        $in_lobby = array();
        $fd = fopen("../private/in_lobby", "c+");
      }
      else
      {
        $fd = fopen("../private/in_lobby", "c+");
        flock($fd, LOCK_SH);
        $in_lobby = unserialize(file_get_contents("../private/in_lobby"));
        flock($fd, LOCK_UN);
      }
      if (!in_array($_SESSION["logged_on_user"], $in_lobby))
      {
        $in_lobby[] = $_SESSION["logged_on_user"];
        flock($fd, LOCK_EX);
        file_put_contents("../private/in_lobby", serialize($in_lobby));
        flock($fd, LOCK_UN);
      }
      fclose($fd);
?>
<html>
  <head>
    <title>Cool Lobby</title>
  </head>
  <body style="background-color:#130E27">
    <script>
        function changeURL( url ) {
          document.location = url;
        };
    </script>
    <h1 style="text-align: center; color: white">Cool Player Lobby</h1>
    <iframe name="chat" src="chat.php" width="100%" height="550px"></iframe>
    <iframe name="speak" src="speak.php" width="100%" height="50px" style="border:none;"></iframe>
    <br/>
    <h2 style="color:white">Also in lobby: </h2>
    <iframe name="players" src="in_lobby.php" width="100%" height="300px" style="border:none;"></iframe>
    <!--<h3><a href="../game/index.php" style="color:white">Click here to start a game!</a></h3>-->
    <a href="logout.php" style="color:white">You are logged in as <i><?php echo $_SESSION["logged_on_user"] ?></i>. Click here to logout.</a>
    <br/>
  </body>
</html>

<?php
  }
}
?>
