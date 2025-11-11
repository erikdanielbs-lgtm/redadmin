<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuscarPorIpRequest extends FormRequest
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
            'ip' => [
                'required',
                'ipv4',
                //Falla automáticamente si la IP no existe en la tabla registros.
                'exists:registros,ip',
            ],
        ];
    }

     public function messages(): array
    {
        return [
            'ip.required' => 'La dirección IP es obligatoria.',
            'ip.ipv4' => 'La dirección IP no tiene un formato válido.',
            // Este mensaje se muestra si 'exists' falla.
            'ip.exists' => 'No se encontró ningún registro con esa IP.',
        ];
    }
}