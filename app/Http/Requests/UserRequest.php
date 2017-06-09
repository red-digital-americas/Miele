<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if($this->get("id") === NULL)
            return [
                    'name'              => 'required|string|max:45|min:3',
                    'last_name'         => 'required|string|max:45',
                    'mothers_last_name' => 'max:45',
                    'email'             => 'required|email|max:255|unique:users,email',
                    'password'          => 'required|string|min:5',
                    "address"           => 'string',
                    "telephone"         => 'string',
                    "mobile_phone"      => 'string'
                ];
        
        return [
            "id"                => "integer|required|min:1",
            'name'              => '|string|max:45|min:3',
            'last_name'         => '|string|max:45',
            'mothers_last_name' => 'max:45',
            'email'             => '|email|max:255|unique:users,email',
            'password'          => 'string|min:5',
            "address"           => 'string',
            "telephone"         => 'string',
            "mobile_phone"      => 'string'
        ];
       
    }
    
    public function messages()
    {
        return [
            'name.required'     => 'El nombre es requerido',
            'name.max'          => 'El nombre no debe sobrepasar los 45 caracteres',
            'name.string'       => 'El nombre debe ser una cadena',
            'name.min'          => 'El nombre debe ser mayor a 3 caracteres',
            'last_name.required'=> 'El apellido paterno es obligatorio',
            'last_name.string'  => 'El apellido paterno debe ser una cadena',
            'last_name.max'     => 'El apellido paterno no debe sobrepasar los 45 caracteres',
            'email.required'    => 'El email es obligatorio',
            'email.email'       => 'El email es inválido',
            'email.unique'      => 'El email ya existe',
            'telephone.string'  => 'El teléfono debe ser alfanumérico',
            'address.string'    => 'La dirección debe ser alfanumérico',
            'telephone.string'  => 'El teléfono debe ser alfanumérico',
            'mobile_phone'      => 'El teléfono móvil debe ser alfanumérico',
            'password.required' => 'El password es obligatorio',
            'password.string'   => 'El password debe ser alfanumérico',
            'password.min'      => 'El password debe ser de almenos 5 caracteres',
            'id.required'       => 'El id es obligatorio',
            'id.min'            => 'El id debe ser mayor a 0',
            'id.integer'        => 'El id debe ser numérico'
        ];
    }
    
    public function response(array $errors){ 
        return response()->json($errors, 400); 
        
    }
}
