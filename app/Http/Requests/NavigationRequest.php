<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class NavigationRequest extends BackendRequest
{
    public function rules()
    {

        return [
            'sort' => 'required|integer',
            'name' => 'required',
            'url' => 'required|url',
        ];

    }
}