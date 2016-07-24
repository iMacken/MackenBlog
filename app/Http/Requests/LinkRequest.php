<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LinkRequest extends BackendRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort' => 'required|integer',
            'name' => 'required',
            'url' => 'required|url',
        ];
    }
}
