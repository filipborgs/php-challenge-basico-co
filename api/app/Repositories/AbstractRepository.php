<?php

namespace App\Repositories;

use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;

abstract class AbstractRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = app($model);
    }

    protected function validator($data, $rules)
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }
    }
}
