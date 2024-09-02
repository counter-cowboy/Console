<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Must be a string type',
            'email.required' => 'Email is required',
            'email.string' => 'Must be a string'

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw  new HttpResponseException(response()
        ->json([
            'message'=>'Validation errors',
            'data'=>[
                'errors'=>$validator->errors()
            ]
        ]));
    }

    public function authorize(): bool
    {
        return true;
    }
}
