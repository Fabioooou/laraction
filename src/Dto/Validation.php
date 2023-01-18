<?php

namespace Laraction\Dto;

trait Validation
{
  /**
   * validate dto
   * ---------------------
   * 
   * @return bool|Illuminate\Validation\ValidationException
   */
  public function validate(){
    return call_user_func(substr(get_class($this), 0, strlen(get_class($this)) - 3) . 'Validation::validate', $this->toArray());
  }
}