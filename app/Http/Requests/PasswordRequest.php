<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            "email" => "email|required"
        ];
    }
    
    public function update(){
        return [
            "id" => "integer|required|min:1"
        ];
    }
    
    public function messages()
    {
        return [
            'email.required' =>  'Email obligatorio',
            'email.email' => 'Debe de ser un email válido',
            'email.unique' => 'El email ya existe',
            'id.required' => 'El id es obligatorio',
            'id.min' => 'El id debe ser mayor a 0'
        ];
    }
    
    public function response(array $errors){ 
        return response()->json($errors, 400); 
        
    }
}
