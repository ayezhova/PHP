<?php

class Tyrion extends Lannister
{
  public function sleepWith($object)
  {
    if ($object instanceof Jaime)
    {
      print("Not even if I'm drunk !" . PHP_EOL);
    }
    else if ($object instanceof Sansa)
    {
      print("Let's do this." . PHP_EOL);
    }
    else if ($object instanceof Cersei)
    {
      print("Not even if I'm drunk !" . PHP_EOL);
    }
  }
}


?>
