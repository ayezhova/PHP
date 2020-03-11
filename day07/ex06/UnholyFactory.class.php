<?php
class UnholyFactory
{
	public $absorbed = array();

	public function absorb($object)
	{
		if (is_subclass_of($object, 'Fighter'))
		{
			if (array_key_exists($object->name, $this->absorbed))
			{
				print("(Factory already absorbed a fighter of type foot soldier)" . PHP_EOL);
			}
			else
			{
				$this->absorbed[$object->name] = $object;
				print("(Factory absorbed a fighter of type " . $object->name . ")" . PHP_EOL);
			}
		}
		else
		{
			print("(Factory can't absorb this, it's not a fighter)" . PHP_EOL);
		}
	}
	public function fabricate($makeName)
	{
		if (array_key_exists($makeName, $this->absorbed))
		{
			print("(Factory fabricates a fighter of type " . $makeName . ")" . PHP_EOL);
			return clone $this->absorbed[$makeName];
		}
		else {
			print("(Factory hasn't absorbed any fighter of type " . $makeName . ")" . PHP_EOL);
		}
	}
}
?>
