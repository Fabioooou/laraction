<?php

namespace Laraction\Operations\Action;

use Illuminate\Support\Str;
use Laraction\Operations\Action\Traits\HasOperation;
use Laraction\Operations\Action\Interface\OperationActionInterface;

class DeleteOperationAction implements OperationActionInterface
{
    use HasOperation;

    public function variables(): array
    {
        return [
            '{{scriptDelete}}' => $this->getScriptDelete(),
        ];
    }

    public function stub(): string
    {
        return $this->config()->getStubDirectory()  . DIRECTORY_SEPARATOR . 'operation' . DIRECTORY_SEPARATOR . 'action_delete.stub';
    }

    public function file(): string
    {
        return  $this->config()->getActionDirectory() . Str::ucfirst(Str::camel($this->config()->getEntity())) . Str::ucfirst(Str::camel($this->action['name'])).'.php';
    }

    public function entity(): string
    {
        return strtolower($this->config()->getEntity());
    }

    public function getScriptDelete()
    {
        $primaryKeyName = $this->columnList->getPrimaryColumnName() ?? 'id';

		$data  = '';
		$data .= PHP_EOL;
		$data .= '$'.strtolower($this->config->getEntity()). ' =  '. $this->config->getEntity() . '::where("'.$primaryKeyName.'", $this->request()->'.$primaryKeyName.')->first();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;
		$data .= 'if (empty($'.strtolower($this->config->getEntity()). ')){';
		$data .= PHP_EOL;
		$data .= '	throw new BusinessException("Not found '.$this->config->getEntity().' ");';
		$data .= PHP_EOL;
		$data .= '}';
		$data .= PHP_EOL;
		$data .= PHP_EOL;
        $data .= PHP_EOL;
		$data .= 'return $'.strtolower($this->config->getEntity()). '->delete();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		return $this->indent($data, 8);
    }


}
