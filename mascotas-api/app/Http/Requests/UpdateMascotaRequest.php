<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMascotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:255',
            'especie' => 'sometimes|string|in:perro,gato',
            'raza' => 'sometimes|string',
            'edad' => 'sometimes|integer|min:0',
            'persona_id' => 'sometimes|exists:personas,id',
        ];
    }
}
