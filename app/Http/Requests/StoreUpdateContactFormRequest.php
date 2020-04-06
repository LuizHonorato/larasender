<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateContactFormRequest extends FormRequest
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
        $id = $this->segment(3);

        return [
            'first_name' => "required|min:3|max:50",
            'last_name' => "required|min:3|max:50",
            'email' => "required|unique:customers,email,{$id},id",
            'password' => "required",
            'profile_pic' => "image"
        ];
    }
}
