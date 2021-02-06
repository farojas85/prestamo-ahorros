<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoCuotaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:191',
            'dias' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Campo :attribute es Obligatorio',
            'nombre.string' => 'Ingrese cadena de textos',
            'nombre.max' => 'Ingrese Máximo :max caracteres',
            'dias.required' => 'Campo :attribute es Obligatorio',
            'dias.numeric' => 'Ingrese sólo números'
        ];
    }
}
