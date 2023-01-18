<?php

namespace Laraction;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class Validation 
{
 	static public function validate($data): bool
	{
		$validator = Validator::make(
				$data,
				static::rules(),
				static::messages(),
			);

		if($validator->fails()){
				throw new ValidationException($validator, response($validator->errors(), 422));
		}

		return $validator->fails();
	}
}