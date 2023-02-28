<?php

namespace Laraction\Dto;

trait HasInput
{

  public static function input(array $input): ?Self
  {
    $class = new \ReflectionClass(get_class());
    $parameters = $class->getConstructor()?->getParameters();
    $validsParameters = [];
    foreach($parameters as $param){
      if(isset($input[$param->name])){
        $validsParameters[] = $input[$param->name];
      }
    }
    return $class->newInstanceArgs($validsParameters);
  }

}