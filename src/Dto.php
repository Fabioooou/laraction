<?php


namespace Laraction;

use Laraction\Dto\DtoInterface;

abstract class Dto implements DtoInterface
{

  public function toArray()
  {
    return get_object_vars($this);
  }


	public function __set($property, $value)
	{
		$method = 'set'.ucfirst($property).'Attribute';
		return (is_callable([$this, $method])) ? $this->$method($value) : $value;
	}

	public function __get($property)
	{
		$method = 'get'.ucfirst($property).'Attribute';
		$value  = isset($this->$property) ? $this->$property : null;
		return (is_callable([$this, $method])) ? $this->$method() : $value;
	}


}