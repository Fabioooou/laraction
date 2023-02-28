<?php

namespace Laraction\App\Actions\Manager\Schema;

use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;
use Illuminate\Support\Facades\File;

class SchemaStubGenerate
{
	protected ConfigLaractionCreate $config;
	public string $file;
	protected array $variables;
	public string $description;
	public string $path;

	public function __construct(ConfigLaractionCreate $config, SchemaStub $schema)
	{
		$this->config = $config;
		$this->file =  $schema->getStubFile();
		$this->variables =  $schema->getStubVariables();
		$this->description =  $schema->getStubDescription();
		$this->path =  $schema->getStubPath();
	}

 	public function run()
	{
		
		$this->makeDirectory(dirname($this->file));
		$this->makeFile($this->file, $this->getContents());

		return $this;
  }


	function makeDirectory($path)
	{
		if(!File::exists($path)) {
			File::makeDirectory($path, 0777, true); 
		}
	}

	function makeFile($filename, $content)
	{
		if(!File::exists($filename)) {
			File::put($filename, $content); 
		}
	}


	function getContents()
	{

		if(!file_exists($this->path)){
			 throw new \Exception('path not found '. $this->path);
		}

		$file = file_get_contents($this->path);

		foreach($this->variables as $name => $value){
			$file = str_replace($name, $value, $file);
		}

		return $file;
	}






}