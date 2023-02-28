<?php

namespace Laraction;

class Service 
{

	static function find($id) {
		return self::model()::find($id);
	}

	static private function model() {
		return static::$model;
	}

	static public function searchWithPagination(array $fields = [], string $search = null, $perPage = 40) 
	{
		$class = self::model();

		if(empty($fields)){
			$model = $class::paginate();
		}

		if(!empty($fields)){
			$model = $class::search($fields, $search)->paginate($perPage);
		}

		return $model;
	}

	static public function search(array $fields = [], string $search = null) 
	{
		$class = self::model();

		if(empty($fields)){
			$model = $class::get();
		}

		if(!empty($fields)){
			$model = $class::search($fields, $search)->get();
		}

		return $model;
	}

	static public function update(array $dto, $id)
	{
		$class = self::model();
		$keyname = (new $class)->getKeyName();
		$model = $class::where($keyname, $id)->first();
		if(empty($model)){
			throw new \Exception("Error when updating. Not found: Entity ". $class. " by " . $keyname . " value ". $id);
		}
		foreach($dto as $field => $value){
			$model->$field = $value;
		}
		$model->save();
		return $model;
	}

	static public function create(array $dto)
	{
		$class = self::model();
		$model = new $class;
		foreach($dto as $field => $value){
			$model->$field = $value;
		}
		$model->save();

		return $model;
	}

	static public function getDto($action = 'Create')
	{
		$class = substr(static::class, 0,strlen(static::class) - 7 );
		return $class . $action . 'Dto';
	}

}