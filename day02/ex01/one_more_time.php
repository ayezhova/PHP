#!/usr/bin/php
<?php
if ($argc == 2)
{
  $date = explode(' ', $argv[1]);

  /* Arrays needed for error checking */
  $month = array("janvier"=>1, "fèvrier"=>2, "fevrier"=> 2, "mars"=> 3, "avril"=> 4, "mai"=>5,
    "juin"=>6, "juillet"=>7, "août"=>8, "aout"=>8, "septembre"=>9,
    "octobre"=>10, "novembre"=>11, "décembre"=>12, "decembre"=>12);
  $max_day = array("janvier"=>31, "fèvrier"=>29, "fevrier"=> 29, "mars"=> 31, "avril"=> 30, "mai"=>31,
    "juin"=>30, "juillet"=>31, "août"=>31, "aout"=>31, "septembre"=>30,
    "octobre"=>31, "novembre"=>30, "décembre"=>31, "decembre"=>31);
  $weekday = array("lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche");

  $loop_once = 1;

  while ($loop_once == 1)
  {
    $loop_once = 0;

    /*check 5 elem (4 spaces) */
    if (count($date) !== 5)
      break;
    $date[0] = lcfirst($date[0]);
    $date[2] = lcfirst($date[2]);

    /* check that weekday is valid; */
    if (array_search($date[0], $weekday) === FALSE)
      break;

    /* check month is valid*/
    if (array_key_exists($date[2], $month) === FALSE)
      break;

    /*check date not a float, not less than 0 and less than or equal to num of days */
    if (is_numeric($date[1]) == FALSE)
      break;
    if(preg_match("/^[0-3][0-9]$|^[0-9]$/", $date[1]) == 0)
      break;
    if ((int)$date[1] > $max_day[$date[2]] || (int)$date[1] < 1)
      break;

    /*check that date is valid */
    if (preg_match("/^[0-9]{4}$/", $date[3]) == 0)
      break;

    /*Check if february was a leap year - if it wasn't, date must be less than 29*/
    if ($date[2] == "fèvrier" || $date[2] == "fevrier")
    {
      if (date('L', mktime(0, 0, 0, 1, 1, $date[3])) == 0)
      {
        if ($date[1] > 28)
          break;
      }
    }

    /*check that the time is valid */
    $subarray = explode(':', $date[4]);
    if (count($subarray) !== 3)
      break;

    /* if there are any chars in subarray not between 0 and 9, break */
    if (preg_match("/[^0-9]/", $subarray[0]) || preg_match("/[^0-9]/", $subarray[1]) || preg_match("/[^0-9]/", $subarray[2]))
      break;
    if (preg_match("/^[0-1][0-9]$|^2[0-3]$/", $subarray[0]) == 0 || preg_match("/^[0-5][0-9]$/", $subarray[2]) == 0 || preg_match("/^[0-5][0-9]$/", $subarray[1]) == 0)
      break;

    /* if we've gotten here, we've passed all the error checks, now just need to give the seconds */
    echo date("U", mktime((int)$subarray[0], (int)$subarray[1], (int)$subarray[2], (int)$month[$date[2]], (int)$date[1], (int)$date[3])) . "\n";

    exit();
  }
  echo "Wrong Format\n";
  /*february second check */
}
?>
