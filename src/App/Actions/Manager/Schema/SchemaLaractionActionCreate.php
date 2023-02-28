<?php

namespace Laraction\App\Actions\Manager\Schema;

use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;
use Laraction\App\Actions\Manager\Util\Column;

class SchemaLaractionActionCreate implements SchemaStub
{
	public array $actionData = [];
	public string $action;
	public ?string $description = null;
	public string $method = 'get';
	public array $columns = [];
	public $uses = [];
	public ?SchemaLaractionColumnCreate $primaryColumn;
	protected ConfigLaractionCreate $config;

	public function __construct(ConfigLaractionCreate $config, array $action){
		
		
		$this->actionData = $action;

		$this->action = $action['name'];
		$this->description = $action['description'];
		$this->config = $config;

		$columns = $action['column'];

		foreach($columns as $name => $column){
			if(!empty($column['enabled'])){
				$this->columns[] = new SchemaLaractionColumnCreate($this->config, $this->action, $column);
			}
		}

		
	}

  public function run(){
		
		return $this;
  }

	function getPrimaryColumn() : ?SchemaLaractionColumnCreate
	{
		$this->primaryColumn = (!empty($this->primaryColumn)) ? $this->primaryColumn : null;

		if(empty($this->primaryColumn)){
			foreach($this->columns as $column){
				if(!empty($column) and $column->getPrimaryKey()){
					$this->primaryColumn = $column;
					return $this->primaryColumn;
				}
			}
		}

		return $this->primaryColumn;
	}

	function getBusinessOperation()
	{
		return !empty($this->actionData['business']['operation']) ? $this->actionData['business']['operation'] : 'create';
	}

	function getBusinessOperationType()
	{
		if($this->getBusinessOperation() ==	'save'){
			return '?'.$this->config->getEntity();
		}

		if($this->getBusinessOperation() ==	'find'){
			return '?'.$this->config->getEntity();
		}

		if($this->getBusinessOperation() ==	'create'){
			return '?'.$this->config->getEntity();
		}

		if($this->getBusinessOperation() ==	'paginate'){
			return '?Paginator';
		}

		if($this->getBusinessOperation() ==	'collection'){
			return '?Collection';
		}

		if($this->getBusinessOperation() ==	'delete'){
			return 'bool';
		}

	}


	function getBusinessOperationUses()
	{
		if($this->getBusinessOperation() ==	'save'){
			$this->uses['business_exception'] = 'use Laraction\Exceptions\BusinessException;';
		}
		if($this->getBusinessOperation() ==	'paginate'){
			$this->uses['paginate'] = 'use Illuminate\Pagination\LengthAwarePaginator as Paginator;';
			$this->uses['business_exception'] = 'use Laraction\Exceptions\BusinessException;';
		}
		if($this->getBusinessOperation() ==	'find'){
			$this->uses['business_exception'] = 'use Laraction\Exceptions\BusinessException;';
		}
		if($this->getBusinessOperation() ==	'collection'){
			$this->uses['business_exception'] = 'use Illuminate\Database\Eloquent\Collection as Collection;';
		}
		if($this->getBusinessOperation() ==	'delete'){
			$this->uses['business_exception'] = 'use Laraction\Exceptions\BusinessException;';
		}

		$data = '';
		foreach($this->uses as $key => $namespace){
			$data .= $namespace;
			$data .= PHP_EOL;
		}

		return $data;

	}

	function getBusinessOperationCode()
	{
		if($this->getBusinessOperation() ==	'create'){
			return $this->getBusinessOperationCreateCode();
		}

		if($this->getBusinessOperation() == 'save'){
			return $this->getBusinessOperationSaveCode();
		}

		if($this->getBusinessOperation() == 'find'){
			return $this->getBusinessOperationFindCode();
		}

		if($this->getBusinessOperation() == 'paginate'){
			return $this->getBusinessOperationPaginateCode();
		}

		if($this->getBusinessOperation() == 'collection'){
			return $this->getBusinessOperationCollectionCode();
		}

		if($this->getBusinessOperation() == 'delete'){
			return $this->getBusinessOperationDeleteCode();
		}
	}

	function getBusinessOperationCollectionCode()
	{
		$data  = '';
		$data .= PHP_EOL;
		$data .= '$'.strtolower($this->config->getEntity()). ' =  '. $this->config->getEntity() . '::all();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data .= 'return $'.strtolower($this->config->getEntity()). ' = new '. $this->config->getEntity() . ';';
		$data .= PHP_EOL;
	
		return $this->indent($data);
		
	}

	function getBusinessOperationPaginateCode()
	{
		$data  = '';
		$data .= PHP_EOL;
		$data .= '$'.strtolower($this->config->getEntity()). ' =  '. $this->config->getEntity() . '::paginate();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data .= 'return $'.strtolower($this->config->getEntity()). ';';
		$data .= PHP_EOL;
	
		return $this->indent($data);
		
	}

	function getBusinessOperationDeleteCode()
	{
		$data  = '';
		$data .= PHP_EOL;
		$data .= '$'.strtolower($this->config->getEntity()). ' =  '. $this->config->getEntity() . '::where("'.$this->getPrimaryColumn()->getName().'", $this->dto()->'.$this->getPrimaryColumn()->getName().')->first();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data .= 'if (empty($'.strtolower($this->config->getEntity()). ')){';
		$data .= PHP_EOL;
		$data .= '	throw new BusinessException("Not found ");';
		$data .= PHP_EOL;
		$data .= '}';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data .= 'return $'.strtolower($this->config->getEntity()). '->delete();';
		$data .= PHP_EOL;
	
		return $this->indent($data);
		
	}

	function getBusinessOperationFindCode()
	{
		$data  = '';
		$data .= PHP_EOL;
		$data .= '$'.strtolower($this->config->getEntity()). ' =  '. $this->config->getEntity() . '::where("'.$this->getPrimaryColumn()->getName().'", $this->dto()->'.$this->getPrimaryColumn()->getName().')->first();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data .= 'if (empty($'.strtolower($this->config->getEntity()). ')){';
		$data .= PHP_EOL;
		$data .= '	throw new BusinessException("Not found ");';
		$data .= PHP_EOL;
		$data .= '}';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data .= 'return $'.strtolower($this->config->getEntity()). ';';
		$data .= PHP_EOL;
	
		return $this->indent($data);
		
	}

	function getBusinessOperationCreateCode()
	{
		$data  = '';
		$data .= '$'.strtolower($this->config->getEntity()). ' = new '. $this->config->getEntity() . ';';
		$data .= PHP_EOL;

		foreach($this->columns as $column){
			$name = (new Column($column))->getName();
			if(empty($this->getPrimaryColumn()) or (!empty($this->getPrimaryColumn()) and ($this->getPrimaryColumn()->getName() <> $name))){
				$data .= '$'.strtolower($this->config->getEntity()). '->'. $name.' = $this->dto()->'.$name.';';
				$data .= PHP_EOL;
			}
		} 

		$data .= PHP_EOL;
		$data .='$'.strtolower($this->config->getEntity()). '->save();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data .='return $'.strtolower($this->config->getEntity()).';';

		$data .= PHP_EOL;
	
		return $this->indent($data);
		
	}


	function getBusinessOperationSaveCode()
	{
		$data  = '';
		$data .= PHP_EOL;
		$data .= '$'.strtolower($this->config->getEntity()). ' =  '. $this->config->getEntity() . '::where("'.$this->getPrimaryColumn()->getName().'", $this->dto()->'.$this->getPrimaryColumn()->getName().')->first();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data .= 'if (empty($'.strtolower($this->config->getEntity()). ')){';
		$data .= PHP_EOL;
		$data .= '	throw new BusinessException("Not found ");';
		$data .= PHP_EOL;
		$data .= '}';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		foreach($this->columns as $column){
			$name = (new Column($column))->getName();
			$data .= '$'.strtolower($this->config->getEntity()). '->'. $name.' = $this->dto()->'.$name.';';
			$data .= PHP_EOL;
		} 

		$data .= PHP_EOL;
		$data .='$'.strtolower($this->config->getEntity()). '->save();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;
		$data .='return $'.strtolower($this->config->getEntity()) .';';
		$data .= PHP_EOL;
		$data .= PHP_EOL;
	
		return $this->indent($data);
		
	}


	function indent($str, $spaces = 4) {
    $parts = array_filter(explode("\n", $str));
    $parts = array_map(function ($part) use ($spaces) {
        return str_repeat(' ', $spaces).$part;
    }, $parts);
    return implode("\n", $parts);
	}

	function getStubFile(): string
	{
		return $this->config->getPathBase(). DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $this->getCapitalizePath()) . DIRECTORY_SEPARATOR . ucfirst(strtolower($this->config->getEntity())) . ucfirst(strtolower($this->action)).'.php' ;
	}

	function getStubVariables(): array
	{
		return [
			'{{namespace}}' => $this->getNamespace(),
			'{{class}}' => $this->config->getEntity() . ucfirst($this->action),
			'{{action}}' => $this->action,
			'{{model}}' => $this->config->getEntity(),
			'{{classDto}}' => $this->config->getEntity() . ucfirst($this->action) . 'Dto',
			'{{businessOperationScript}}' => $this->getBusinessOperationCode(),
			'{{businessOperationUses}}' => $this->getBusinessOperationUses(),
			'{{businessOperationType}}' => $this->getBusinessOperationType(),
		];
	}

	function getNamespace() : string 
	{
		return $this->config->getNamespaceBase() . implode('\\', $this->getCapitalizePath());
	}

	function getStubDescription() : string
	{
		return 'Route Action Create: '. $this->config->getSubsystem();
	}
	
	function getStubPath() : string 
	{
		return $this->config->getStubPath().'/action.stub';
	}

	function getCapitalizePath()
	{
		$capitalized = [];
		foreach($this->config->getRouteArray() as $value){
			$capitalized[] = ucfirst(strtolower($value));
		}

		return $capitalized;
	}


}