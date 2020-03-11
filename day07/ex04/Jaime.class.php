<?php
class Jaime extends Lannister
{
  public function sleepWith($object)
  {
    if ($object instanceof Tyrion)
    {
      print("Not even if I'm drunk !" . PHP_EOL);
    }
    else if ($object instanceof Sansa)
    {
      print("Let's do this." . PHP_EOL);
    }
    else if ($object instanceof Cersei)
    {
      print("With pleasure, but only in a tower in Winterfell, then." . PHP_EOL);
    }
  }
}
?>
