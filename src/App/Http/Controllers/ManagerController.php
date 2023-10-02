<?php

namespace Laraction\App\Http\Controllers;

use Laraction\App\Actions\Manager\Schema\SchemaTableList;
use Laraction\App\Actions\Manager\Schema\SchemaColumnList;
use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Laraction\App\Actions\Manager\Laraction\Laraction;

class ManagerController extends BaseController
{
  /**
	 * Manager - Home
	 *
	 * @return void
	 */
	public function index()
	{
		$tables = (new SchemaTableList)->run();
		return view('laraction::index', compact('tables'));
	}

	/**
	 * Manager - Step 2
	 *
	 * @param string $route
	 * @return Illuminate\View\View
	 */
	public function edit($route)
	{
			$config = (new ConfigLaractionCreate($route));

			$laraction = Laraction::find($route);

			if(!empty($laraction))
			{
				$actions = $laraction->actions();
			}else{
				$actions 	 = ['Create', 'Update', 'List'];
			}

            //dd($config->getCapitalizePath());

			return view('laraction::step2', compact('config', 'actions'));

	}


	/**
	 * Laraction list
	 *
	 * @param Request $request
	 * @param string $route
	 * @return void
	 */
	public function list(Request $request)
	{
		$laractions = Laraction::all();

		return view('laraction::list', compact('laractions'));
	}



	/**
	 * Step 3 - set config laraction detail
	 *
	 * @param Request $request
	 * @param string $route
	 * @return void
	 */
	public function step3(Request $request, $route)
	{
		$data = $request->only('actions');

		Laraction::save($route, $data);

		return redirect('/laraction/list');

	}

	/**
	 * Laraction generate
	 *
	 * @param Request $request
	 * @param string $route
	 * @return void
	 */
	public function generate(Request $request, $route)
	{
		$generated = Laraction::generate($route);

		dd($generated);
	}

	/**
	 * Laraction tree
	 *
	 * @param Request $request
	 * @param string $route
	 * @return void
	 */
	public function tree()
	{
		$tree = Laraction::tree();

		dd($tree);
	}


	/**
	 * Action create (ajax request in step 2)
	 *
	 * @param string $route
	 * @param string $action
	 * @return string
	 */
	public function action($route, $action = null)
	{
        // config
		$config = new ConfigLaractionCreate($route);

        // laraction
		$laraction = Laraction::find($route);
        $laraction = ($laraction and $laraction->action($action)) ? $laraction  : null;

        // if laraction, then.. columns laraction editable
		$columns = ($laraction) ? $laraction->columns($action) : null;
		$editable = ($laraction);

        $laraction = ($laraction) ? $laraction->action($action) : null;

        // if not laraction, then.. columns db
        $columns = (!$columns) ? (new SchemaColumnList($config->getTable()))->run() : $columns;

		$action  = ($action) ? $action : 'NewAction-'.rand(0000001, 9999999999);

        $operations = config('laraction.operations');

		return (string) view('laraction::partials.action', compact('action', 'config', 'columns', 'editable', 'laraction', 'operations'));
	}









}
