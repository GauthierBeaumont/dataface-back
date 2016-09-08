<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DockerRequest extends Request
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
            'userId' => 'integer',
            'db_name' => 'string|max:255',
            'description' => 'string',
            'idApplication' => 'integer',
            'login_user' => 'email',
            'id_docker' => 'string',
            'password_user' => 'string|max:20',
        ];
    }
}
