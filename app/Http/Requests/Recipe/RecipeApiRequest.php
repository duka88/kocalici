<?php

namespace App\Http\Requests\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class RecipeApiRequest extends FormRequest
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
           'title' => 'required|unique:recipes',
            'description' => 'required',
            'image' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'name',
            'tags' => 'required',
        ];
    }
}
