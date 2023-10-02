<?php

namespace Laraction\Operations\Action\Interface;

interface OperationActionInterface
{
    public function variables(): array;  // variables passed to stub
    public function stub(): string; // stub file
    public function file(): string; // action file
    public function entity(): string; // entity passed to view
}
