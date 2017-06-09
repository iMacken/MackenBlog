<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class ArticleRequest extends FormRequest
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
        $id = $this->route('article');
        return [
            'category_id' => 'required',
            'title' => 'required|unique:articles,title,' . $id,
            'slug' => 'required|regex:/^[a-z0-9\-]+$/',
            'content' => 'required',
            'tag_list' => 'required',
            'published_at' => 'date'
        ];

    }
}