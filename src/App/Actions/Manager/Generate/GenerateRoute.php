<?php

namespace Laraction\App\Actions\Manager\Generate;

use Illuminate\Support\Facades\Storage;
use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionActionCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionRouteList;
use Laraction\App\Actions\Manager\Schema\SchemaStubGenerate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionModelCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionDtoCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionValidationCreate;

class GenerateRoute 
{
	protected $route;
	protected $laraction;
	protected array $log;

	public function __construct(string $route, array $laraction)
	{
		$this->route = $route;
		$this->laraction = $laraction;
	}

	public function run()
	{

		$config    = new ConfigLaractionCreate($this->route);
		$actions = [];
		foreach($this->laraction['actions'] as $key => $action)
		{
			$action[$key] = new SchemaLaractionActionCreate($config, $action);
			$stub = (new SchemaStubGenerate($config, $action[$key]))->run();
			$this->log[] = $stub->description;

			$dto   = new SchemaLaractionDtoCreate($config, $action['name'], $action['column']);
			$stub = (new SchemaStubGenerate($config, $dto))->run();
			$this->log[] = $stub->description;

			$validation   = new SchemaLaractionValidationCreate($config, $action['name'], $action['column']);
			$stub = (new SchemaStubGenerate($config, $validation))->run();
			$this->log[] = $stub->description;
		}

		$model 	= new SchemaLaractionModelCreate($config);
		$routes = new SchemaLaractionRouteList($config, $this->laraction['actions']);

		$stub 	= (new SchemaStubGenerate($config, $model))->run();
		$this->log[] = $stub->description;
		$stub 	= (new SchemaStubGenerate($config, $routes))->run();
		$this->log[] = $stub->description;

		return $this->log;
	}

	


}