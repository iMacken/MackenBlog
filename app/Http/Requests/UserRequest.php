<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class UserRequest extends FormRequest
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
        $id = $this->route('user');
        $rules =  [
            'name'     => 'required|unique:users,name,' . $id,
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'confirmed|regex:/^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!~#\$%\^&\-_+=\?])(.{6,})$/',
            'password_confirmation' => '',
        ];
	    if ($this->method() === 'POST') {
		    $rules['password'] .= '|required';
		    $rules['password_confirmation'] .= 'required';
	    }

	    return $rules;
    }
}