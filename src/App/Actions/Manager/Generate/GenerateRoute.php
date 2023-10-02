<?php

namespace Laraction\App\Actions\Manager\Generate;

use Illuminate\Support\Facades\Storage;
use Laraction\App\Actions\Manager\Schema\SchemaStubGenerate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionView;
use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionLayout;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionViewAll;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionDtoCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionRouteList;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionModelCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionValidationCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionActionSimpleCreate;

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
			$actionObj = new SchemaLaractionActionSimpleCreate($config, $action);
			$stub = (new SchemaStubGenerate($config, $actionObj))->run();
			$this->log[] = $stub->description;


            $view = new SchemaLaractionView($config, $action);
			$stub = (new SchemaStubGenerate($config, $view))->run();
			$this->log[] = $stub->description;


		}


        $layout = new SchemaLaractionLayout($config);
        $stub = (new SchemaStubGenerate($config, $layout))->run();
        $this->log[] = $stub->description;

		$model 	= new SchemaLaractionModelCreate($config);
		$stub 	= (new SchemaStubGenerate($config, $model))->run();
		$this->log[] = $stub->description;



		return $this->log;
	}




}
