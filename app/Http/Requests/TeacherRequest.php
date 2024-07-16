<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
        if($this->isMethod('PUT')) {
            $rules = ['prohibited'];
        } else {
            $rules = ['required', 'integer', 'exists:users,id'];
        }
        return [
            'user_id' => $rules,
            'theme' => ['required', 'max:191'],
            'status' => ['required', 'max:191'],
        ];
    }

    public function messages(): array {
        return [
            'user_id.required' => 'O campo user id é obrigatório',
            'user_id.integer' => 'O campo user id precisa ser inteiro',
            'user_id.exists' => 'O campo user id deve ser um usuário válido',
            'theme.required' => 'O campo matéria é obrigatório',
            'theme.max' => 'O campo matéria deve ter no máximo 191 caracteres',
            'status.required' => 'O campo status é obrigatório',
            'status.max' => 'O campo status deve ter no máximo 191 caracteres',
        ];
    }
}
