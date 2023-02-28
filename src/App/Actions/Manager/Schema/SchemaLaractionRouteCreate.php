<?php

namespace Laraction\App\Actions\Manager\Schema;

use Laraction\Action;
use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;

class SchemaLaractionRouteCreate extends Action implements SchemaStub
{

	public string $action;
	public array $columns = [];
	protected ConfigLaractionCreate $config;
	protected SchemaLaractionColumnCreate $primaryKey;

	public function __construct(ConfigLaractionCreate $config, string $action, array $columns){
		$this->action = strtolower($action);
		$this->config = $config;

		foreach($columns as $name => $column){
			if(!empty($column['enabled']))
			{
				 $columnSchema = new SchemaLaractionColumnCreate($this->config, $this->action, $column);

				 if($columnSchema->getPrimaryKey()){
					  $this->primaryKey = $columnSchema;
				 }

				 $this->columns[] = $columnSchema;
			}
		}
	}

  public function run(){
		
		return $this;
  }

	function getPrimaryKey() : SchemaLaractionColumnCreate
	{
		return $this->primaryKey;
	}

	function getStubDescription() : string
	{
		return 'Route '. $this->action;
	}
	
	function getStubPath() : string 
	{
		return $this->config->getStubPath().'/route-action.stub';

	}

	function getStubFile(): string
	{
		return base_path('routes');
	}

	function getStubVariables(): array
	{
		return [
			'{{controller}}' => $this->getController(),
			'{{routename}}' => $this->getRoutename(),
			'{{action}}' => $this->getAction(),
			'{{route}}' => $this->getRoute(),
		];
	}


	public function getController(): string 
	{
		return  $this->config->getNamespaceBase() . implode('/', $this->config->getRouteArray());
	}

	public function getRoutename(): string 
	{
		return  $this->config->getRoute() . '.' .$this->getAction();
	}

	public function getAction(): string 
	{
		return  $this->action;
	}

	public function getRoute() : string
	{
		return implode('/', $this->config->getRouteArray()) .'/'.$this->getAction();
	}

}