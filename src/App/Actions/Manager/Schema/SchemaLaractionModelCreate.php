<?php

namespace Laraction\App\Actions\Manager\Schema;


use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;

class SchemaLaractionModelCreate implements SchemaStub
{
	protected ConfigLaractionCreate $config;
	protected SchemaLaractionColumnCreate $primaryKey;

	public function __construct(ConfigLaractionCreate $config){
		$this->config = $config;
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
		return 'Model '. $this->config->getEntity();
	}
	
	function getStubPath() : string 
	{
		return $this->config->getStubPath().'/model.stub';
	}

	function getStubFile(): string
	{
		return $this->config->getDirRoute() . ucfirst(strtolower($this->config->getEntity())).'.php';
	}

	function getStubVariables(): array
	{
		return [
			'{{class}}' => $this->config->getEntity(),
			'{{namespace}}' => $this->getNamespace(),
		];
	}

	function getNamespace() : string 
	{
		return $this->config->getNamespaceBase() . implode('\\', $this->config->getCapitalizePath());
	}




}