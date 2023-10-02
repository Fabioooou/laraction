<?php

namespace Laraction\Operations\Action;

use Illuminate\Support\Str;
use Laraction\App\Actions\Manager\Util\Column;
use Laraction\Operations\Action\Traits\HasOperation;
use Laraction\Operations\Action\Interface\OperationActionInterface;

class PaginateOperationAction implements OperationActionInterface
{
    use HasOperation;

    public function variables(): array
    {
        return [
            '{{scriptPaginate}}' => $this->getScriptPaginate(),
            '{{entity}}' => $this->entity(),
        ];
    }

    public function stub(): string
    {
        return $this->config()->getStubDirectory() . DIRECTORY_SEPARATOR . 'operation' . DIRECTORY_SEPARATOR . 'action_paginate.stub';
    }

    public function file(): string
    {
        return  $this->config()->getActionDirectory() . Str::ucfirst(Str::camel($this->config()->getEntity())) . Str::ucfirst(Str::camel($this->action['name'])).'.php';
    }

    public function entity(): string
    {
        return strtolower($this->config()->getEntity().'s');
    }

    public function getScriptPaginate()
    {
		$data  = '';
		$data .= PHP_EOL;
        $data .= PHP_EOL;
        $data .= PHP_EOL;
		$data .= '$this->'.$this->entity(). ' =  '. $this->config->getEntity() . '::paginate();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;
        $data .= PHP_EOL;
		$data .= 'return $this->'.$this->entity().';';
		$data .= PHP_EOL;

		return $this->indent($data, 8);
    }



}
