<?php

namespace Laraction\App\Actions\Manager\Util;

use Laraction\App\Actions\Manager\Schema\SchemaLaractionColumnCreate;

class Column 
{

	protected SchemaLaractionColumnCreate $column;

	public function __construct(SchemaLaractionColumnCreate $column)
	{
		$this->column = $column;
	}

	function getTypephp() : string
	{
		$type = 'string';
		$type = ($this->column->type == 'integer') ? 'int' : $type;
		$type = ($this->column->type == 'datetime') ? 'string' : $type;
		$type = ($this->column->type == 'json') ? 'array' : $type;
		$type = ($this->column->type == 'boolean') ? 'bool' : $type;
		$type = ($this->column->type == 'decimal') ? 'float' : $type;
		$type = ($this->column->type == 'float') ? 'float' : $type;

		return $this->getNotnullphp(). $type;
	}

	function getNotnullphp() : ?string
	{
		return (!$this->column->notnull) ? '?' : '';
	}

	function getPropertyPromotion() : ?string
	{
		return 'public '. $this->getTypephp() . ' $'.$this->column->name;
	}

	function getName() : ?string
	{
		return $this->column->name;
	}

	function getValidation() : ?string
	{
		return $this->column->validate;
	}



}