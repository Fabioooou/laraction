<?php

namespace Laraction\App\Actions\Manager\Schema;

use Laraction\App\Actions\Manager\Util\Column;
use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;


class SchemaLaractionColumnList
{

	public $action;
	public array $columns = [];
	protected ConfigLaractionCreate $config;
    public $primaryColumn;

	public function __construct(ConfigLaractionCreate $config,  $action){
		$this->action = $action;
		$this->config = $config;

        $this->getColumns();
	}

    public function run()
    {
        return $this;
    }

    public function getColumns() : array
    {
        if(empty($this->columns))
        {
            foreach($this->action['column'] as $name => $column){
                if(!empty($column['enabled'])){
                    $this->columns[] = new SchemaLaractionColumnCreate($this->config, $this->action, $column);
                }

                if(!empty($column['primaryKey'])){
                    //$this->primaryColumn = $column;
                    $this->primaryColumn = new SchemaLaractionColumnCreate($this->config, $this->action, $column);
                }
            }
        }

        return $this->columns;
    }

    public function getPrimaryColumn()
    {
        if(empty($this->primaryColumn))
        {
            foreach($this->getColumns() as $column){
                if(!empty($column) and $column->getPrimaryKey()){

                    $this->primaryColumn = $column;
                }
            }
        }

        return $this->primaryColumn;
    }

    public function getPrimaryColumnName(): string
    {
        return $this->getPrimaryColumn()?->getName() ?? '';
    }

    public function getRules() : array
    {
        $rules = [];
        foreach($this->getColumns() as $name => $column)
        {
            $rules[$name] = (new Column($column))->getValidation();
        }

        return $rules;
    }



}
