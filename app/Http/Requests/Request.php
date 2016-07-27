<?php

namespace App\Http\Requests;

use \Illuminate\Validation\Factory;
use \Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Validates the input,
     * Override the parent method to add sanitize
     */
    public function validator(Factory $factory) : Validator
    {
        return $factory->make(
            $this->sanitizeInput(), $this->container->call([$this, 'rules']), $this->messages()
        );
    }

    protected function sanitizeInput() : array
    {
        if (method_exists($this, 'sanitize')) {
            return $this->container->call([$this, 'sanitize']);
        }

        return $this->all();
    }
}
