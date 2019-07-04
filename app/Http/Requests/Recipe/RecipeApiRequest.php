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
            'description' => 'required|max:255',
            'image' => 'required',
            'content' => 'required|max:2550',
            'category_id' => 'required',
            'name' => 'required|max:255',
            'tags' => 'required|max:255',
            'amount' => 'required|max:255',
             'time' => 'required|integer|max:240',
            'dificulty' => 'required|integer|max:10',
            'servings' => 'required|integer|max:100'
        ];
    }
}
