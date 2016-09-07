<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileRequest extends Request
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
          'id' => 'integer|max:10',
          'lastName' => 'string|max:255',
          'firstName' => 'string|max:255',
          'address' => 'string|max:255',
          'country' => 'string|max:100',
          'phone' => 'string|max:30',
          'postalCode' => 'string|max:20',
          'email' => 'email|max:255',
          'password' => 'string|min:6',
        ];
    }
}
