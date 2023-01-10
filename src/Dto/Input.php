<?php

namespace Laraction\Dto;

trait Input
{

  public static function input(array $input): ?Self
  {
    $class = new \ReflectionClass(get_class());
    return  $class->newInstanceArgs($input);
  }

}