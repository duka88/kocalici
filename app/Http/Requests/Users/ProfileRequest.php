<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
             'name' => 'required|max:255',
             'email' => "unique:users,email,$this->id,id|required|max:255",
            'password' => 'sometimes|string|min:6',
            'about' => 'max:255',
            'full_name' => 'max:255'
        ];
    }
}
