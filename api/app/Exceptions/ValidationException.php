<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{

    public function __construct($erros)
    {
        if (is_array($erros)) {
            $this->message = implode(PHP_EOL, $erros);
        } else {
            $this->message = $erros;
        }
    }

    public function toArray()
    {
        return array('message' => $this->message);
    }

    public function render()
    {
        return  response()->json(['message' => $this->message], 400);
    }
}
