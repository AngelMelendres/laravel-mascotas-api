<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Mascota;

class StoreMascotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $persona_id = $this->input('persona_id');
                    if ($persona_id && Mascota::where('persona_id', $persona_id)->where('nombre', $value)->exists()) {
                        $fail('La persona ya tiene una mascota con ese nombre.');
                    }
                }
            ],
            'especie' => ['required', 'string', Rule::in(['perro', 'gato'])],
            'raza' => ['required', 'string'],
            'edad' => ['required', 'integer', 'min:0'],
            'persona_id' => ['required', 'exists:personas,id'],
        ];
    }
}
