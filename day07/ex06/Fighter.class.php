<?php
abstract class Fighter
{
	public $name;
	abstract public function fight($target);
	public function __construct($arg) {
		$this->name = $arg;
	}
}
?>
