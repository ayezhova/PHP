#!/usr/bin/php
<?php
  /* using https://gist.github.com/eua1024/e4f69ffdbcc191c81e953d1d67913e4e and
     https://www.w3schools.com/php/func_misc_unpack.asp */
  date_default_timezone_set("America/Los_Angeles");

  if (file_exists("/var/run/utmpx") == FALSE)
    exit();
  $fd = fopen("/var/run/utmpx", "r");
  $MyLogIns = array();
  while ($string = fread($fd, 628)) {
    $unpackedString = unpack("a256Username/a4TerminalID/a32TerminalName/i2LoginType/I2Time", $string);
    if ($unpackedString['LoginType2'] == "7")
      $MyLogIns[] = $unpackedString;
  }

  foreach($MyLogIns as $login)
  {
    echo $login['Username']." ".$login['TerminalName']."  ".date("M  j H:i", $login['Time1'])."\n";
  }

?>
