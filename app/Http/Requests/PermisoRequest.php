<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class PermisoRequest extends FormRequest
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
        $id = $this->route('id') ?? $this->route('permiso');

        return [
            'nombre_permiso' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-z_]+$/', 
                Rule::unique('permisos', 'nombre_permiso')->ignore($id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            //
        ];
     }


}
