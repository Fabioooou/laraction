<?php

namespace Laraction\App\Actions\Manager\Schema;

class SchemaColumnList
{
	public ?string $table = null;

	public function __construct(string $table){
		$this->table = $table;
	}

  public function run(){
		$tables = (new SchemaTableList)->run();
		return $tables[$this->table];
  }

}