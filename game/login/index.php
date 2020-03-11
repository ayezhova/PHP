<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset = "utf-8">
    <title>Warhero</title>
    <link rel="stylesheet" type="text/css" href="index.css" />
   </head>
  <body>
    <h1>Welcome, Warhero!</h2>
    <div id="headerImg">
      <img src = "maxresdefault.jpg" style="vertical-align:middle; margin-top: -30%">
    </div>
    <div id="block" style="float: left;">
      <span id="reviewer">
        <img id="filip" src="Filip_Miucin.jpg" />
        <h3 id="filName">Filip Muicin</h3>
      </span>
      <span id="Reviewtext">
      In most games of this genre, your coolest skills and spells are often set to strictly long recharge timers or a limited mana system, but in Warheros, your abilities have incredibly quick recharges and allow you to seamlessly integrate these gadgets in normal encounters and it doesn’t make you feel penalized for using your cool stuff. Warheros only falters slightly with some repetition setting in, especially on the early areas and during longer play sessions. Warheros figures out an intriguing way to have your rogue-like and Metroidvania experience all in one by focusing on your failures and encouraging you to try something new the next time.
      </span>
    </div>
    <div id="tabDiv">
      <button class="tab" onclick="formClick(event, 'LogIn')">Log In</button>
      <button class="tab" onclick="formClick(event, 'Modify')">Modify Account</button>
      <button class="tab" onclick="formClick(event, 'Delete')">Delete Account</button>
      <button class="tab" onclick="formClick(event, 'Create')">Create Account</button>
  
    <div id="LogIn" class="inTab">
      <form name="login.php" method="post" action="login.php" style="margin: 5px;">
        Username: <input type="text" name="login" value=""  style="margin: 5px;"/>
        <br />
        Password: <input type="password" name="passwd" value=""  style="margin: 5px;"/>
        <input type="submit" name="submit" value="OK" />
      </form>
    </div>
    <div id="Create" class="inTab">
      <iframe name="Create" src="create.php" width="100%" height="600px"></iframe>
    </div>
    <div id="Modify" class="inTab">
      <iframe name="Modify" src="modif.php" width="100%" height="600px"></iframe>
    </div>
    <div id="Delete" class="inTab">
      <iframe name="Delete" src="delete.php" width="100%" height="600px"></iframe>
    </div>
</div>
  <script>
  function formClick(evt, formRequested)
{
    var i = 0;
    var tabcontents;
    var tabs;
    
    tabcontents = document.getElementsByClassName("inTab");
    while (i < 4)
    {
        tabcontents[i].style.display = "none";
        i++;
    }
    tabs = document.getElementsByClassName("tab");
    i = 0;
    while (i < 4)
    {
        tabs[i].className = tabs[i].className.replace(" active", "");
        i++;
    }
    document.getElementById(formRequested).style.display = "block";
    evt.currentTarget.className += " active";
    
}
  </script>
  </body>
</html>
