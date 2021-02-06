<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tipo_documento_id' => 'required',
            'numero_documento' => 'required|unique:personas,numero_documento',
            'nombres' => 'required|string|max:191',
            'apellidos' => 'required|string|max:191',
            'sexo' => 'required',
            'telefono' => 'required',
            'direccion' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'tipo_documento_id.required' => 'Campo :attribute es Obligatorio',
            'numero_documento.required' => 'Campo :attribute es Obligatorio',
            'nombres.required' => 'Campo :attribute es Obligatorio',
            'apellidos.required' => 'Campo :attribute es Obligatorio',
            'sexo.required' => 'Campo :attribute es Obligatorio',
            'numero_documento.unique' => 'Número Ya existente',
            'telefono.required' => 'Campo :attribute es Obligatorio',
            'direccion.required' => 'Campo :attribute es Obligatorio'
        ];
    }
}
