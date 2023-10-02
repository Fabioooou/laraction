<?php

namespace Laraction\Operations\Action;

use Illuminate\Support\Str;
use Laraction\App\Actions\Manager\Util\StubGenerate;
use Laraction\Operations\Action\Traits\HasOperation;
use Laraction\Operations\Action\Interface\OperationActionInterface;
use Laraction\App\Actions\Manager\Schema\SchemaLaractionColumnCreate;

class SaveFormOperationAction implements OperationActionInterface
{
    use HasOperation;

    public function variables(): array
    {
        return [
            '{{entity}}' => $this->entity(),
        ];
    }

    public function stub(): string
    {
        return $this->config()->getStubDirectory()  . DIRECTORY_SEPARATOR  . 'operation' . DIRECTORY_SEPARATOR . 'action_save_form.stub';
    }

    public function file(): string
    {
        return  $this->config()->getActionDirectory() . Str::ucfirst(Str::camel($this->config()->getEntity())) . Str::ucfirst(Str::camel($this->action['name'])).'.php';
    }

    public function entity(): string
    {
        return strtolower($this->config()->getEntity());
    }

}
