<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('personas')->ignore($this->persona),
            ],
            'fecha_nacimiento' => 'sometimes|date|before:today',
        ];
    }
}
