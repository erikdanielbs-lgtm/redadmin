<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DependenciaRequest extends FormRequest
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
        $id = $this->route('dependencia');

        return [
            'nombre' => 'required|string|max:100|unique:dependencias,nombre,' . $id,
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la dependencia es obligatorio.',
            'nombre.string' => 'El nombre debe contener solo letras.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'nombre.unique' => 'Ya existe una dependencia con ese nombre.',
        ];
    }
}
