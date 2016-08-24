<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfilePutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'id' => 'max:10|unique:users',
          'lastName' => 'max:255',
          'firstName' => 'max:255',
          'address' => 'max:255',
          'country' => 'max:100',
          'phone' => 'max:30',
          'postalCode' => 'max:20',
          'email' => 'max:255',
          'password' => 'min:6',
        ];
    }
}
