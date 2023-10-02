<?php

namespace Laraction\App\Actions\Manager\Schema;

use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionColumnList;
use Laraction\Operations\View\Interface\OperationInterface;
use Illuminate\Support\Str;

class SchemaLaractionView implements SchemaStub
{

	public $action;
    public $actionName;
	public array $columns = [];
    public SchemaLaractionColumnList $columnList;
	protected ConfigLaractionCreate $config;

	public function __construct(ConfigLaractionCreate $config,  $action){
		$this->action = $action;
		$this->config = $config;
	}

    public function getColumns()
    {
        $this->columnList = new SchemaLaractionColumnList($this->config, $this->action);
        $this->columns = $this->columnList->getColumns();

        return $this->columns;
    }

    public function run(){
        return $this;
    }

	function getStubFile(): string
	{
		return resource_path('views') . DIRECTORY_SEPARATOR .
            strtolower(implode(DIRECTORY_SEPARATOR, $this->getCapitalizePath())) . DIRECTORY_SEPARATOR .
            strtolower($this->config->getEntity()) . '-' . Str::snake($this->action['name'], '-').'.blade.php' ;
	}


    function getOperation() : OperationInterface
    {
        $config = config('laraction.operations.'. $this->action['business']['operation']);
        $operation = (!empty($config)) ? (new $config['view']($this->config, $this->action)) : null;

        return $operation;
    }

	function getStubVariables(): array
	{
        $operation = $this->getOperation();
        $variables = ($operation) ? $operation->variables() : [];

		return [
			'{{layoutName}}' => $this->getLayoutName(),
			'{{model}}' => $this->getModel(),
            '{{entity}}' => $this->config->getEntity(),
		] + $variables;
	}

    function getLayoutName(): string
    {
        return $this->action['view']['layout_name'] ?? strtolower($this->config->getSubsystem());
    }


    function getModel() : string
    {
        return  strtolower($this->config->getEntity());
    }

	function getStubDescription() : string
	{
		return 'View '. $this->action['name'];
	}

	function getStubPath() : string
	{
        $operation = $this->getOperation();
        $stub = ($operation) ? $operation->stub() : '';

		return $this->config->getStubPath(). DIRECTORY_SEPARATOR . $stub;
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
