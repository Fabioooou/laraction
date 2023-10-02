<?php

namespace Laraction\App\Actions\Manager\Util;

use Illuminate\Support\Str;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionColumnCreate;

class InputHtml
{

	public function __construct(public SchemaLaractionColumnCreate $column)
	{
        //
	}

    function type() : string
    {
        return 'text';
    }

    function required(): string
    {
        return $this->column->getRequired();
    }

    function name() : string
    {
        return $this->column->getName();
    }

    function label() : string
    {
        return ucfirst(str_replace('_',' ',$this->column->getName()));
    }

    function placeholder() : string
    {
        return ucfirst(str_replace('_',' ',$this->column->getName()));
    }

    function id() : string
    {
        return Str::slug($this->column->getName());
    }


}
