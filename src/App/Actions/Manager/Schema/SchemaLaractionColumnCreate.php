<?php

namespace Laraction\App\Actions\Manager\Schema;

use Laraction\Action;
use Laraction\App\Traits\ToArray;

class SchemaLaractionColumnCreate extends Action
{
	use ToArray;

	public $name = null;
	public $type = null;
	public $notnull = null;
	public $default = null;
	public $validate = null;
	public $primaryKey = null;
	public $origin = null;
	public $autoincrement = null;
	public $length = null;
	public $precision = null;
	public $scale = null;
	public $fields = [];

	public function __construct($laraction, $action, array $fields)
	{
		$this->primaryKey = (!empty($fields['primaryKey']));
		$this->name = (!empty($fields['name'])) ? $fields['name'] : null;
		$this->type = (!empty($fields['type'])) ? $fields['type'] : null;
		$this->notnull = (!empty($fields['notnull'])) ? $fields['notnull'] : null;
		$this->default = (!empty($fields['default'])) ? $fields['default'] : null;
		$this->validate = (!empty($fields['validate'])) ? $fields['validate'] : null;
		$this->origin = (!empty($fields['origin'])) ? $fields['origin'] : null;
		$this->autoincrement = (!empty($fields['autoincrement'])) ? $fields['autoincrement'] : null;
		$this->length = (!empty($fields['length'])) ? $fields['length'] : null;
		$this->precision = (!empty($fields['precision'])) ? $fields['precision'] : null;
		$this->scale = (!empty($fields['scale'])) ? $fields['scale'] : null;
		$this->fields = $fields;
	}

  public function run(): array
	{
		return $this->toArray();
  }


	public function getPrimaryKey() : string
	{
		return $this->primaryKey;
	}

	/**
	 * Get the value of name
	 */
	public function getName() : string
	{
		return $this->name;
	}

	/**
	 * Get the value of type
	 */
	public function getType() : string
	{
		return $this->type;
	}

	/**
	 * Get the value of notnull
	 */
	public function getNotnull() : string
	{
		return $this->notnull;
	}

	/**
	 * Get the value of default
	 */
	public function getDefault() : string
	{
		return $this->default;
	}

	/**
	 * Get the value of validate
	 */
	public function getValidate() : string
	{
		return $this->validate;
	}

    public function getRequired() : string
    {
        return (str_contains($this->validate, 'required')) ? 'required' : '';
    }

	/**
	 * Get the value of origin
	 */
	public function getOrigin() : string
	{
		return $this->origin;
	}

	/**
	 * Get the value of autoincrement
	 */
	public function getAutoincrement()
	{
		return $this->autoincrement;
	}

	/**
	 * Get the value of length
	 */
	public function getLength()
	{
		return $this->length;
	}

	/**
	 * Get the value of scale
	 */
	public function getScale()
	{
		return $this->scale;
	}

	/**
	 * Get the value of precision
	 */
	public function getPrecision()
	{
		return $this->precision;
	}
}
