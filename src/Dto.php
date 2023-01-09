<?php


namespace Laraction;

abstract class Dto
{

  public static function input(array $input): ?Self
  {
    $class = new \ReflectionClass(get_class());
    return  $class->newInstanceArgs($input);
  }

}