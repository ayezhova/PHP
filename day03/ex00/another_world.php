#!/usr/bin/php
<?php
  if ($argc > 1)
  {
    $stripped = trim(preg_replace("/\s+/", " ", $argv[1]));
    echo $stripped . "\n";
  }
?>
