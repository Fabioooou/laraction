<?php


namespace Laraction;

abstract class Dto
{

  public function toArray()
  {
    return get_object_vars($this);
  }

}