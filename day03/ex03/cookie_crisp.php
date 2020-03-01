<?php
    /*
        If this program, we want to be able to create, read and delete a cookie.
        To do so, we will need three things from the url. We'll need the action - 
        'set', 'get', or 'del'. We'll also need the 'name' of the cookie. In the 
        case that we are setting the cookie, we will also need the 'value' of
        the cookie.
    */
    if (array_key_exists('action', $_GET) === FALSE)
        return;
    $action = $_GET['action'];
    if ($action === "set" && array_key_exists('name', $_GET) && array_key_exists('value', $_GET))
        setcookie($_GET['name'], $_GET['value'], time() + 3600);
    if ($action === "get" && array_key_exists('name', $_GET) && isset($_COOKIE[$_GET['name']]))
        echo $_COOKIE[$_GET['name']] . PHP_EOL;
    if ($action === "del" && array_key_exists('name', $_GET))
        setcookie($_GET['name'], "" , time() - 3600);
?>