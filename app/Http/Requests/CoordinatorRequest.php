<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoordinatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id']
        ];
    }

    public function messages(): array {
        return [
            'user_id.required' => 'O campo user id é obrigatório',
            'user_id.integer' => 'O campo user id precisa ser inteiro',
            'user_id.exists' => 'O campo user id deve ser um usuário válido'
        ];
    }
}
