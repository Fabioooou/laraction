<?php

namespace Laraction\App\Actions\Manager\Schema;

class SchemaLaractionOperationList
{

    public array $defaults = [
        'save' => Laraction\Operations\SaveOperation::class,
        'find' => '',
        'create' => '',
        'paginate' => '',
        'colection' => '',
        'delete' => '',
    ];

    public array $config = [];

    function __construct()
    {
        $this->config = config('laraction.operations') ?? [];
    }

    function all() : array
    {
        return array_merge($this->defaults, $this->config);
    }
}
