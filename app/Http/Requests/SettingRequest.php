<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class SettingRequest extends BackendRequest
{
    public function rules()
    {

        return [
            'name' => 'required',
            'value' => 'required',
        ];

    }
}