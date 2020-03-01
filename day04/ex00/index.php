<?php
    session_start();
    
    if (isset($_GET['submit']) && $_GET['submit'] === "OK")
    {
        if (isset($_GET['login']))
            $_SESSION['login'] = $_GET['login'];
        if (isset($_GET['passwd']))
            $_SESSION['passwd'] = $_GET['passwd'];
    }
?>
<html><body>
<form name ="index.php" method="get">
    Username: <input type="text" name="login" value="<?php
        if (isset($_SESSION['login']))
            echo $_SESSION['login'];
    ?>" />
    <br />
    Password: <input type="text" name="passwd" value="<?php
        if (isset($_SESSION['passwd']))
            echo $_SESSION['passwd'];
    ?>" />
    <input type="submit" name="submit" value="OK" >
</body></html>