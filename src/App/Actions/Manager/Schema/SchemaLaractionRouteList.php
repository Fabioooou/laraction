<?php

namespace Laraction\App\Actions\Manager\Schema;


use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;

class SchemaLaractionRouteList implements SchemaStub
{
	protected $schema = [];
	protected $actions;
	protected ConfigLaractionCreate $config;

	public function __construct($config, $actions){

		$this->actions = $actions;
		$this->config = $config;

		foreach($this->actions as $action){
			$this->schema[] = new SchemaLaractionRouteCreate($this->config, $action['name'], $action['column'] );
		}
		
	}

  public function run()
  {
		


		return $this->schema;
  }

	function getStubDescription() : string
	{
		return 'Route List: '. $this->config->getSubsystem();
	}
	
	function getStubPath() : string 
	{
		return $this->config->getStubPath().'/route-group.stub';
	}

	function getStubFile(): string
	{
		return  base_path('routes').'/'. strtolower($this->config->getSubsystem()).'.php';
	}

	function getStubVariables(): array
	{
		return [
			'{{middlewares}}' => '["web"]',
			'{{routes}}' => $this->generateRoutes()
		];
	}

	function generateRoutes()
	{
		$stub = '';
		foreach($this->schema as $schema){
			$stub .= (new SchemaStubGenerate($this->config, $schema))->getContents();
		}
		return $stub;
	}
}