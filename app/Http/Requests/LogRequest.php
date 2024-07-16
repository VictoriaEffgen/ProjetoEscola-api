<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest
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
            $rulesIssuer = ['prohibited'];
            $rulesReferent = ['prohibited'];
        } else {
            $rulesIssuer = ['required', 'integer', 'exists:coordinators,id'];
            $rulesReferent = ['required', 'integer', 'exists:students,id'];
        }
        return [
            'event' => ['required','string', 'max:191'],
            'duration' => ['required', 'in:1,2,3'],
            'date_initial'=> ['required', 'date_format:Y-m-d'],
            'issuer_id' => $rulesIssuer,
            'referent_id' => $rulesReferent
        ];
    }
}
