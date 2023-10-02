<?php

namespace Laraction\Operations\View;

use Laraction\Operations\View\Interface\OperationInterface;
use Laraction\Operations\View\Traits\HasOperation;

class SaveOperationView implements OperationInterface
{
    use HasOperation;

    public function variables() : array
    {
        return $this->variable;
    }

    public function stub() : string
    {
        return  DIRECTORY_SEPARATOR . 'operation' . DIRECTORY_SEPARATOR . 'view_save.stub';;
    }

}
