<?php

namespace Laraction;

use Laraction\Action\HasRequest;
use Illuminate\Support\Facades\Route;

abstract class Action
{
    use HasRequest;

    public function json(): \Illuminate\Http\JsonResponse
    {
        $this->mergeRouteParams();
        $this->run();
        return response()->json($this->toArray());
    }

    public function execute()
    {
        return $this->run();
    }

    public function view()
    {
        $this->mergeRouteParams();
        $this->run();

        return view($this->autoView(), $this->toArray());
    }

}
