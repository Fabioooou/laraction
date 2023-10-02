<?php

namespace Laraction\Operations\View\Traits;

use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionColumnList;

trait HasOperation
{
    protected $variable = [];
    protected SchemaLaractionColumnList $columnList;

    function __construct(public ConfigLaractionCreate $config, public array $action)
    {
        $this->columnList = new SchemaLaractionColumnList($config, $action);
    }

    function config() : ConfigLaractionCreate
    {
        return $this->config;
    }

    function getColumns()
    {
        return $this->columnList->getColumns();
    }

    function getPrimaryColumn()
    {
        return $this->columnList->getPrimaryColumn();
    }

    function indent($str, $spaces = 4) {
        $parts = array_filter(explode("\n", $str));
        $parts = array_map(function ($part) use ($spaces) {
            return str_repeat(' ', $spaces).$part;
        }, $parts);
        return implode("\n", $parts);
    }

}
