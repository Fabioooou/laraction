<?php

namespace Laraction\App\Actions\Manager\Schema;


class SchemaLaractionSubsystemCreate
{
	protected $options = [];
	protected $config;

	public function __construct($config, array $options){

		$this->config = $config;
		$this->options = $options;

	}

 	public function run(){
		
		return $this;
  	}


  	function getRouteFile()
  	{
  		return base_path('routes/'.strtolower($this->config['subsystem']).'.php');
  	}

}