<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
        $id = $this->route('page');
        return [
            'title' => 'required|unique:pages,title,' . $id,
            'slug' => 'required|regex:/^[a-z0-9\-]+$/',
            'content' => 'required',
        ];

    }
}