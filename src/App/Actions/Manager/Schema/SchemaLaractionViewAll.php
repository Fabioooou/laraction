<?php

namespace Laraction\App\Actions\Manager\Schema;

use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;

class SchemaLaractionViewAll implements SchemaStub
{

	public $action;
    public $actionName;
	public array $columns = [];
	protected ConfigLaractionCreate $config;

	public function __construct(ConfigLaractionCreate $config,  $action){
		$this->action = $action;
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

	function getStubFile(): string
	{
		return resource_path('views') . DIRECTORY_SEPARATOR . strtolower(implode(DIRECTORY_SEPARATOR, $this->getCapitalizePath())) . DIRECTORY_SEPARATOR . strtolower($this->config->getEntity()) . '_' . strtolower($this->action['name']).'.blade.php' ;
	}

	function getStubVariables(): array
	{
		return [
			'{{layoutName}}' => $this->getLayoutName(),
			'{{paginateTitle}}' => $this->getPaginateTitle(),
			'{{paginateList}}' => $this->getPaginateList(),
            '{{paginateItem}}' => $this->getPaginateItem(),
			'{{model}}' => $this->getModel(),
            '{{entity}}' => $this->config->getEntity(),
		];
	}

    function getLayoutName(): string
    {
        return strtolower($this->config->getSubsystem());
    }

    function getPaginateTitle() : string
    {
        return  $this->config->getEntity() . ' ' .  $this->action['name'];
    }

    function getPaginateList() : string
    {
        return  strtolower($this->config->getEntity() .'_' . $this->action['name']);
    }

    function getPaginateItem() : string
    {
        return  strtolower($this->config->getEntity());
    }

    function getModel() : string
    {
        return  strtolower($this->config->getEntity());
    }

	function getStubDescription() : string
	{
		return 'View All '. $this->action['name'];
	}

	function getStubPath() : string
	{
		return $this->config->getStubPath().'/view-all.stub';
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
