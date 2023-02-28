<?php

namespace Laraction\App\Actions\Manager\Schema;

use Laraction\Action;
use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Schema\Table;

class SchemaTableCreate extends Action
{

	protected \Doctrine\DBAL\Schema\Table $table;
	
	public function __construct(\Doctrine\DBAL\Schema\Table $table)
	{
		$this->table = $table;
	}

	

  public function run(): array
  {
		
		$tables = DB::getDoctrineSchemaManager()->listTables();
		foreach($tables as $table){
			foreach($table->getColumns() as $column){
				if(!in_array($column->getName(), ['created_at', 'updated_at']))
        {
					$this->tableList[$table->getName()][$column->getName()] = 
          [
						'name' => $column->getName(),
						'type' => $column->getType()->getName(),
						'length' => $column->getLength(),
						'notnull' => $column->getNotNull(),
						'default' => $column->getDefault(),
						'autoincrement' => $column->getAutoIncrement(),
						'precision' => $column->getPrecision(),
						'scale' => $column->getScale(),
						'primaryKey' => (!empty($table->getPrimaryKey()?->getColumns()[0]) and ($table->getPrimaryKey()?->getColumns()[0] == $column->getName())),
					];
				}
			}
		}
		return $this->tableList;
  }

}