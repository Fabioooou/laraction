<?php

namespace Laraction\Operations\View;

use Laraction\Operations\View\Traits\HasForm;
use Laraction\Operations\View\Traits\HasOperation;
use Laraction\Operations\View\Interface\OperationInterface;

class CreateFormOperationView implements OperationInterface
{
    use HasOperation, HasForm;

    public function variables() : array
    {
        $this->addTitle()
             ->addForm();

        return $this->variable;
    }

    protected function addTitle()
    {
        $this->variable['{{title}}'] =  'Create ' . $this->config()->getEntity();

        return $this;
    }

    protected function addForm()
    {
        $this->variable['{{form}}'] = $this->formStub('create');

        return $this;
    }

    public function stub() : string
    {
        return 'create_form.stub';
    }

    public function entity(): string
    {
        return strtolower($this->config()->getEntity());
    }


}
