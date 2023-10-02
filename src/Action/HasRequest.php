<?php

namespace Laraction\Action;

use Laraction\Services\Request;

trait HasRequest
{

    private $request = null;
    private $request_type;

    static function fromArray($array)
    {
        $static = new static;
        $static->setRequest($static, $array);
        return $static;
    }

    static function fromRequest()
    {
        $static = new static;
        $static->setRequest($static, request());
        return $static;
    }

    function setRequest($class, $data)
    {
        if(!empty($data) and is_array($data)){
            $request = new \Laraction\Services\Request($data);
            $class->request = $request;
            $class->request_type = 'array';
        }

        if(empty($data)){
            $class->request = request();
            $class->request_type = 'request';
        }
    }

    function getRequest()
    {
      if($this->request_type == 'array'){
        return $this->request;
      }

      if($this->request_type <> 'array'){
        return request();
      }
    }

    function request($array = null)
    {
        if(!is_null($array))
            $this->setRequest($this, $array);

        return $this->getRequest();
    }

    function mergeRouteParams()
    {
        $parameters = $this->request()?->route()?->parameters();
        if($parameters){
            $this->request()->merge($parameters);
        }
    }

    protected function autoView() : string
    {
        $route = array_reverse(explode('\\', get_class($this)));
        $usecase = $route[0];
        $entity = strtolower($route[1]);
        $domain = strtolower($route[2]);
        $system = strtolower($route[3]);

        $usecase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $usecase));

        return $system . '.'. $domain . '.'. $entity. '.'.$usecase;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
