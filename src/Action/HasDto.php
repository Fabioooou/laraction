<?php

namespace Laraction\Action;

trait HasDto
{

	public $_dto; 

	protected function createDtoFromArray(array $inputs, $staticClass = null) : \Laraction\Dto\DtoInterface
	{
		return $this->newDto($inputs, $staticClass);
	}

	protected function createDto(array $inputs, $staticClass = null) : \Laraction\Dto\DtoInterface
	{
		return $this->newDto($inputs, $staticClass);
	}

	protected function newDto(array $inputs, $staticClass = null) : \Laraction\Dto\DtoInterface
	{
		$staticClass = ($staticClass) ? $staticClass : get_class($this) . 'Dto';
		$this->_dto =   call_user_func($staticClass. '::input', $inputs);

		return $this->_dto;
	}

	protected function dto() : \Laraction\Dto\DtoInterface
	{
		return $this->getDto();
	}

	protected function getDto() : \Laraction\Dto\DtoInterface
	{
		return $this->_dto;
	}
}