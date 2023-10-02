<?php

namespace Laraction\Operations\View\Interface;

interface OperationInterface
{
    public function variables(): array;
    public function stub(): string;
}
