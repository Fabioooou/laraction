<?php

namespace Laraction\App\Actions\Manager\Schema;

use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;

class SchemaLaractionLayout implements SchemaStub
{

	public function __construct(public ConfigLaractionCreate $config){
        //
	}

    public function run(){
        return $this;
    }

	function getStubFile(): string
	{
		return resource_path('views/layouts') . DIRECTORY_SEPARATOR . $this->getLayoutName() . '.blade.php' ;
	}

	function getStubVariables(): array
	{
		return [
			'{{layoutName}}' => $this->getLayoutName(),
		];
	}

    function getLayoutName(): string
    {
        return strtolower($this->config->getSubsystem());
    }

	function getStubDescription() : string
	{
		return 'Layout:  '. $this->getLayoutName();
	}

	function getStubPath() : string
	{
		return $this->config->getStubPath().'/layout.stub';
	}




}
