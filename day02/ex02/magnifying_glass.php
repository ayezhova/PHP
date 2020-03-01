#!/usr/bin/php
<?php
  if ($argc == 2)
  {
    if (file_exists($argv[1]) == FALSE)
      exit(1);
    $string = file_get_contents($argv[1]);

    $string = preg_replace_callback("/(<a .*?>)(.*?)(<)/",
    function($matches)
    {
      return $matches[1].strtoupper($matches[2]).$matches[3];
    },
    $string);

    $string = preg_replace_callback("/(title *= *\")(.*?)(\")/",
    function($matches)
    {
      return $matches[1].strtoupper($matches[2]).$matches[3];
    },
    $string);

    echo $string;
  }
?>
