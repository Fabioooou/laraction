<?php

namespace Laraction\Operations\View;

use Laraction\Operations\View\Interface\OperationInterface;
use Laraction\Operations\View\Traits\HasOperation;

class PaginateOperationView implements OperationInterface
{
    use HasOperation;

    public function variables() : array
    {
        $this->addPaginateTitle()
             ->addPaginateList()
             ->addPaginateItem();

        return $this->variable;
    }

    protected function addPaginateTitle()
    {
        $this->variable['{{paginateTitle}}'] = $this->config()->getEntity() . ' List';

        return $this;
    }

    protected function addPaginateList()
    {
        $this->variable['{{paginateList}}'] = strtolower($this->config()->getEntity()).'s';

        return $this;
    }

    protected function addPaginateItem()
    {
        $this->variable['{{paginateItem}}'] = strtolower($this->config()->getEntity());

        return $this;
    }

    public function stub() : string
    {
        return 'paginate.stub';
    }

}
