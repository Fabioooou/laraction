<?php

namespace Laraction\Operations\Action;

use Illuminate\Support\Str;
use Laraction\App\Actions\Manager\Util\Column;
use Laraction\Operations\Action\Traits\HasOperation;
use Laraction\Operations\Action\Interface\OperationActionInterface;

class SaveOperationAction implements OperationActionInterface
{
    use HasOperation;

    public function variables(): array
    {
        return [
            '{{scriptSave}}' => $this->getScriptSave(),
            '{{scriptValidate}}' => $this->getScriptValidate(),
            '{{entity}}' => $this->entity(),
        ];
    }

    public function stub(): string
    {
        return $this->config()->getStubDirectory()  . DIRECTORY_SEPARATOR . 'operation' . DIRECTORY_SEPARATOR . 'action_save.stub';
    }

    public function file(): string
    {
        return  $this->config()->getActionDirectory() . Str::ucfirst(Str::camel($this->config()->getEntity())) . Str::ucfirst(Str::camel($this->action['name'])).'.php';
    }

    public function entity(): string
    {
        return strtolower($this->config()->getEntity());
    }

    public function getScriptSave()
    {

        $primaryKeyName = $this->columnList->getPrimaryColumnName() ?? 'id';

		$data  = '';
		$data .= PHP_EOL;
		$data .= '$this->'.strtolower($this->config->getEntity()). ' =  '. $this->config->getEntity() . '::where("'.$primaryKeyName.'", $this->request()->'.$primaryKeyName.')->first();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data .= 'if (empty($this->'.strtolower($this->config->getEntity()). ')){';
		$data .= PHP_EOL;
		$data .= '	throw new BusinessException("Not found '.$this->config->getEntity().' ");';
		$data .= PHP_EOL;
		$data .= '}';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data  = '';
        $data .= PHP_EOL;
		$data .= '$this->'.strtolower($this->config->getEntity()). ' = new '. $this->config->getEntity() . ';';
		$data .= PHP_EOL;

		foreach($this->getColumns() as $column){
			$name = (new Column($column))->getName();

			if( ($column) and (!$column->getPrimaryKey()) ){
				$data .= '$this->'.strtolower($this->config->getEntity()). '->'. $name.' = $this->request()->'.$name.';';
				$data .= PHP_EOL;
			}
		}

		$data .= PHP_EOL;
		$data .='$this->'.strtolower($this->config->getEntity()). '->save();';
		$data .= PHP_EOL;
		$data .= PHP_EOL;

		$data .='return $this->'.strtolower($this->config->getEntity()).';';

		$data .= PHP_EOL;

		return $this->indent($data, 8);
    }

    public function getScriptValidate()
    {
        $data = '';
        $data .= PHP_EOL;
        $fields = [];
        foreach($this->getColumns() as $column){
            $fields[] = "   '".$column->name."' => '".(new Column($column))->getValidation()."'";
        }

        if(!empty($fields))
        {
            $data .= '$this->request()->validate(';
            $data .= PHP_EOL.$this->indent(PHP_EOL.'['.PHP_EOL.$this->indent(implode(','. PHP_EOL. '', $fields),4). '   '.PHP_EOL.']'.PHP_EOL.'', 8);
            $data .= ', []);';
        }

        return $data;
    }






}
