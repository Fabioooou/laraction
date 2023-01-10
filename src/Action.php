<?php


namespace Laraction;

abstract class Action
{

	public $dto;

	protected function dto($dto)
	{
		$this->dto =   call_user_func(get_class($this) . 'Dto'. '::input', $dto);

		return $this;
	}


}