<?php
 
namespace App\Http\Requests\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
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
            //'title' =>  "unique:recipes,title,$this->id,id|required|max:255",
            'description' => 'required',            
            'content' => 'required',
            'category' => 'required',
            'image' => 'required',
        ];
    }
}
