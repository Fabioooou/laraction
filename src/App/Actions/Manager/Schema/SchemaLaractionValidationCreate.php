<?php

namespace Laraction\App\Actions\Manager\Schema;

use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;
use Laraction\App\Actions\Manager\Util\Column;

class SchemaLaractionValidationCreate implements SchemaStub
{

	public string $action;
	public array $columns = [];
	protected ConfigLaractionCreate $config;

	public function __construct(ConfigLaractionCreate $config, string $action, array $columns){
		$this->action = $action;
		$this->config = $config;

		foreach($columns as $name => $column){
			if(!empty($column['enabled'])){
				$this->columns[] = new SchemaLaractionColumnCreate($this->config, $this->action, $column);
			}
		}
	}

  public function run(){
		
		return $this;
  }

	function getStubFile(): string
	{
		return $this->config->getPathBase(). DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $this->getCapitalizePath()) . DIRECTORY_SEPARATOR . ucfirst(strtolower($this->config->getEntity())) . ucfirst(strtolower($this->action)).'Validation.php' ;
	}

	function getStubVariables(): array
	{
		return [
			'{{namespace}}' => $this->getNamespace(),
			'{{class}}' => $this->config->getEntity() . ucfirst($this->action),
			'{{action}}' => $this->action,
			'{{model}}' => $this->config->getEntity(),
      '{{rules}}' => $this->getRules(),
      '{{messages}}' => '',
		];
	}

  function getRules()
  {
    $fields = [];
    foreach($this->columns as $column){
      $fields[] = "   '".$column->name."' => '".(new Column($column))->getValidation()."'";
    } 

    return (!empty($fields)) ?  PHP_EOL.'     '.implode(','. PHP_EOL. '    ', $fields). '   '.PHP_EOL.'    ' : '';
  } 

	function getNamespace() : string 
	{
		return $this->config->getNamespaceBase() . implode('\\', $this->getCapitalizePath());
	}

	function getStubDescription() : string
	{
		return 'Dto '. $this->action;
	}
	
	function getStubPath() : string 
	{
		return $this->config->getStubPath().'/validation.stub';
		
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