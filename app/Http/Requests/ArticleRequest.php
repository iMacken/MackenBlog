<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class ArticleRequest extends BackendRequest
{
    public function rules()
    {

        return [
            'category_id' => 'required',
            'title' => 'required',
            'slug' => 'required|regex:/^[a-z0-9\-]+$/',
            'content' => 'required',
            'tag_list' => 'required',
        ];

    }
}