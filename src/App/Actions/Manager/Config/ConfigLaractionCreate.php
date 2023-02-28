<?php

namespace Laraction\App\Actions\Manager\Config;

use Illuminate\Support\Str;
use Laraction\App\Traits\ToArray;

class ConfigLaractionCreate 
{
	use ToArray;

	public string $route;
	public string $subsystem;
	public string $domain;
	public string $entity;
	public string $table;
	public string $dir;
	public string $theme;
	public string $path_base;
	public string $path_stubs;
	public string $namespace_base;
	protected array $route_array;


	public function __construct(string $route)
	{
		$this->route = $route;

		$route = $this->getRouteArray();

		$this->subsystem = ucfirst(strtolower($route[0]));
		$this->domain = ucfirst(strtolower($route[1]));
		$this->entity = ucfirst(strtolower($route[2]));
		$this->table = Str::plural($route[2]);
		$this->dir = 'App/Actions/'.implode('/', $route);

		$this->theme = (config('laraction.theme')) ? config('laraction.theme') : 'default';
		$this->path_base = (config('laraction.path_base')) ? config('laraction.path_base') : base_path().'/app/Actions/';
		$this->path_stubs = (config('laraction.path_stubs')) ? config('laraction.path_stubs') : base_path('stubs/laraction');
		$this->namespace_base = (config('laraction.namespace_base')) ? config('laraction.namespace_base') : "App\Actions\\";


		if(!$this->subsystem){
			throw new \Exception('Invalid route: '. $this->route);
		}

	}

	public function run()
	{
		return $this->toArray(); 
	}


		/**
	 * config - SchemaLaractionRouteCreate
	 */
	public function getDefaultRouteCreate() : array
	{
		return [
			'main' => false,
		];
	}

	/**
	 * config - SchemaLaractionRouteList
	 */
	public function getDefaultRouteList() : array
	{
		return [
			'middlewares' => ['web'],
		];
	}
	


	public function getRouteArray() : array
	{
		return (!empty($this->route_array)) ? $this->route_array : explode('.', $this->route);
	}

	/**
	 * Get the value of entity
	 */ 
	public function getEntity() : string
	{
		return $this->entity;
	}

	/**
	 * Get the value of table
	 */ 
	public function getTable() : string
	{
		return $this->table;
	}

	/**
	 * Get the value of dir
	 */ 
	public function getDir() : string
	{
		return $this->dir;
	}

	/**
	 * Get the value of domain
	 */ 
	public function getDomain() : string
	{
		return $this->domain;
	}

	/**
	 * Get the value of subsystem
	 */ 
	public function getSubsystem() : string
	{
		return $this->subsystem;
	}

	/**
	 * Get the value of route
	 */ 
	public function getRoute() : string
	{
		return $this->route;
	}

	/**
	 * Get the value of theme
	 */ 
	public function getTheme()
	{
		return $this->theme;
	}

	/**
	 * Get the value of namespace_base
	 */ 
	public function getNamespaceBase()
	{
		return $this->namespace_base;
	}



	/**
	 * Get the value of path_base
	 */ 
	public function getPathBase()
	{
		return $this->path_base;
	}

	/**
	 * Get the value of path_base
	 */ 
	public function getPathStubs()
	{
		return $this->path_stubs;
	}

	/**
	 * Get the value of path_base
	 */ 
	public function getStubPath()
	{
		return $this->path_stubs;
	}

	public function getDirRoute()
	{
		return $this->getPathBase(). DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $this->getCapitalizePath()) . DIRECTORY_SEPARATOR ;
	}

	function getCapitalizePath()
	{
		$capitalized = [];
		foreach($this->getRouteArray() as $value){
			$capitalized[] = ucfirst(strtolower($value));
		}
		return $capitalized;
	}
}