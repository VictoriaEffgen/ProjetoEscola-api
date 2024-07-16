<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'name' => ['required', 'max:191'],
            'age' => ['required', 'integer'],
            'email' => ['required', 'email', 'unique:App\Models\User,email'],
            'password' => ['required', Password::min(6)],
            'type' => ['prohibited']
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'name.max' => 'O campo nome deve ter no máximo 191 caracteres',
            'age.required' => 'O campo idade é obrigatório',
            'age.integer' => 'O campo idade tem que ter numero inteiro',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O email não é válido',
            'email.unique' => 'Email já cadastrado',
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'O campo senha deve ter no minimo 6 dígitos',
            'type.prohibited' => 'O campo tipo é proibido'
        ];
    }
}
