<?php

namespace Laraction\Services;

use Illuminate\Http\Request as HttpRequest;

class Request extends HttpRequest
{
    function validate($rules, $messages = null)
    {
        $data = $this->all();
        $messages = (!is_null($messages)) ? $messages : [];

        if(!empty($data) and (is_array($data) or (is_object($data))))
        {
            $validator = \Illuminate\Support\Facades\Validator::make((array) $data, $rules, $messages);

            if ($validator->fails()) {
               throw new \Illuminate\Validation\ValidationException($validator);
            }
        }else{
            return request()->validate($rules, $messages);
        }
    }
}
