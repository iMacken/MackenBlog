<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class TagRequest extends BackendRequest
{

    public function rules()
    {
        return [
            'name' => 'required',
            'slug' => 'required|regex:/^[a-z0-9\-]+$/',
        ];
    }

}