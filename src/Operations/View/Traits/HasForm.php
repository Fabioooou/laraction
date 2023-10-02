<?php

namespace Laraction\Operations\View\Traits;

use Laraction\App\Actions\Manager\Util\StubGenerate;
use Laraction\App\Actions\Manager\Config\ConfigLaractionCreate;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionColumnList;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionColumnCreate;
use Laraction\App\Actions\Manager\Util\InputHtml;

trait HasForm
{


    protected function formStub($state = 'create')
    {
        $data = '<form id="frm-'.$this->entity().'-'.$state.'" method="post">';
        $data .= PHP_EOL;
        $data .= '@csrf';
        $data .= PHP_EOL;

        foreach($this->getColumns() as $column)
        {
            $data .= PHP_EOL;
            $data .= $this->indent($this->inputStub($column, $state));
            $data .= PHP_EOL;
        }

        $data .= PHP_EOL;
        $data .= PHP_EOL;

        $data .= '<button>Save</button>';

        $data .= PHP_EOL;
        $data .= PHP_EOL;
        $data .= '</form>';

        return $data;
    }

    protected function inputStub(SchemaLaractionColumnCreate $column, $state) : string
    {
        $stubFile = $this->config()->getStubDirectory()  . DIRECTORY_SEPARATOR  . 'form' . DIRECTORY_SEPARATOR . 'input_text.stub';

        $input = new InputHtml($column);

        return (new StubGenerate(
            $stubFile,
            '',
            [
                '{{id}}' => $input->id(),
                '{{name}}' => $input->name(),
                '{{label}}' => $input->label(),
                '{{placeholder}}' =>  $input->placeholder(),
                '{{value}}' => ($state == 'save') ? '{{$'.$this->entity().'->'.$column->getName().'}}' : '',
                '{{type}}' => 'text',
                '{{required}}' => $input->required(),
            ]
        ))->content();


    }

}
