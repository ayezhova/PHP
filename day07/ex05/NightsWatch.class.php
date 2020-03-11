<?php

class NightsWatch
{
	public $fighters = array();
	public function recruit($object)
	{
		$this->fighters[] = $object;
	}
	public function fight()
	{
		foreach ($this->fighters as $fighter)
		{
			if (is_subclass_of($fighter, 'IFighter'))
			{
				$fighter->fight();
			}
		}
	}
}

?>
