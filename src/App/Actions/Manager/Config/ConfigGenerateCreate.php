<?php

namespace Laraction\App\Actions\Manager\Config;

use Laraction\Action;
use Illuminate\Support\Str;
use Laraction\App\Traits\ToArray;

class ConfigGenerateCreate extends Action
{
	use ToArray;

	protected ConfigLaractionCreate $laraction;


	public function __construct(string $route, array $actions)
	{
		$this->laraction = (new ConfigLaractionCreate($route))->run();
	}

	public function run()
	{
		return $this->toArray(); 
	}

}