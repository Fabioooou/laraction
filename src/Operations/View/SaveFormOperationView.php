<?php

namespace Laraction\Operations\View;

use Illuminate\Support\Str;

use Laraction\Operations\View\Traits\HasForm;
use Laraction\Operations\View\Traits\HasOperation;
use Laraction\Operations\View\Interface\OperationInterface;

class SaveFormOperationView implements OperationInterface
{
    use HasOperation, HasForm;

    public function variables(): array
    {
        return [
            '{{entity}}' => $this->entity(),
            '{{form}}' => $this->form(),
            '{{title}}' => $this->title(),
        ];
    }


    public function stub(): string
    {
        return  DIRECTORY_SEPARATOR  . 'operation' . DIRECTORY_SEPARATOR . 'view_save_form.stub';
    }

    public function file(): string
    {
        return  $this->config()->getActionDirectory() . Str::ucfirst(Str::camel($this->config()->getEntity())) . Str::ucfirst(Str::camel($this->action['name'])).'.php';
    }

    public function entity(): string
    {
        return strtolower($this->config()->getEntity());
    }

    public function form(): string
    {
        return $this->formStub('save');
    }

    public function title() : string
    {
        return ucfirst(strtolower($this->config()->getEntity())) . ' edit';
    }













}
