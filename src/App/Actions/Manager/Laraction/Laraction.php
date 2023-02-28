<?php

namespace Laraction\App\Actions\Manager\Laraction;

use Illuminate\Support\Facades\Storage;
use Laraction\App\Traits\ToArray;
use Laraction\App\Actions\Manager\Generate\GenerateRoute;


class Laraction
{
	use ToArray;

	protected array $data = [];

	public function __construct($data = null)
	{
		$this->data = $data;
	}


	static public function all() : ?array
	{
		$data = [];
		foreach(Storage::files('laraction') as $key => $item){
			$data[$key]['name'] = str_replace(['laraction'. DIRECTORY_SEPARATOR, '.json'] , '', $item);
			$data[$key]['updated_at'] = Storage::lastModified($item);
			$data[$key]['file'] = $item;
		}
		return $data;
	}

	static public function find($route) 
	{
		$exists = Storage::exists('laraction/' . $route.'.json');
		$laraction = ($exists) ? Storage::get('laraction/' . $route.'.json') : null;

		return ($laraction) ? new self(json_decode($laraction, true)) : null;
	}


	public function actions() : array
	{
		$actions = [];
		foreach($this->data['actions'] as $data){
			$actions[] = $data['name'];
		}
		return $actions;
	}

  public function action($action)
	{
		foreach($this->data['actions'] as $data){
			if($data['name'] == $action){
				return $data;
			}
		}
	}

  public function columns($action) : ?array
	{
		$action = $this->action($action);
		return (!empty($action['column'])) ? $action['column'] : null;
	}


	static public function save($route, $contents) : bool
	{
		Storage::makeDirectory('laraction');
		Storage::put('laraction/' . $route.'.json', json_encode($contents, true));

		return Storage::exists('laraction/' . $route.'.json');
	}

	static public function generate($route) :?array
	{
		$laraction = Laraction::find($route);
		$data = $laraction->toArray()['data'];

		return (new GenerateRoute($route, $data))->run();
	}

	static public function tree()
	{
		$all = Laraction::all();
		$tree = [];
		
		

		foreach($all as $key => $item)
		{
			$param = explode('.', $item['name']);

				$tree[$param[0]] = (!empty($tree[$param[0]])) ? $tree[$param[0]] : [];
				$tree[$param[0]][$param[1]] = (!empty($tree[$param[0]][$param[1]])) ? $tree[$param[0]][$param[1]] : [];

				if(!in_array($param[2], $tree[$param[0]][$param[1]]))
				{
					$laraction = Laraction::find($item['name'])->toArray();
					$tree[$param[0]][$param[1]][$param[2]] = $laraction['data'];
				}
		}
		return $tree;
	}


}