<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateMailboxFormRequest extends FormRequest
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

    public function messages()
    {
        return [
            'email.unique'  => 'Caixa de entrada já cadastrada.',
            'user_id.required' => 'O campo usuário é obrigatório'
        ];
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
            'email' => "required|unique:mailboxes,email,{$id},id",
            'user_id' => "required"
        ];
    }
}
