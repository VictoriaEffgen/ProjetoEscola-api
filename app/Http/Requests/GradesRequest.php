<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradesRequest extends FormRequest
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
            $rulesStudent = ['prohibited'];
            $rulerTeacher = ['prohibited'];
        } else {
            $rulesStudent = ['required', 'integer', 'exists:students,id'];
            $rulerTeacher = ['required', 'integer', 'exists:teachers,id'];
        }
        return [
            'student_id' => $rulesStudent,
            'teacher_id' => $rulerTeacher,
            'grade' => ['required', 'numeric', 'between:0,40.00'],
            'quarter' => ['required', 'integer']
        ];
    }

    public function messages(): array {
        return [
            'student_id.required' => 'O campo aluno id é obrigatório',
            'student_id.integer' => 'O campo aluno id precisa ser inteiro',
            'student_id.exists' => 'O campo aluno id deve ser válido',
            'teacher_id.required' => 'O campo professor id é obrigatório',
            'teacher_id.integer' => 'O campo professor id precisa ser inteiro',
            'teacher_id.exists' => 'O campo professor id deve ser válido',
            'grade.required' => 'O campo nota é obrigatório',
            'grade.numeric' => 'O campo nota precisa ser um numero',
            'grade.between' => 'O campo nota precisa estar entre 0 à 40',
            'quarter.required' => 'O campo trimestre é obrigatório',
            'quertar.integer' => 'O campo trimestre deve ser um numero inteiro',
        ];
    }
}
