<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
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
        return 
            array('message' => ['required','max:160'])
        ;
    }
    
    //Mensajes tras cumplir las reglas
    public function messages()
    {
        return 
          array('message.required' => 'Por favor, escribe tu mensaje',
                'message.max'      => 'El mensaje no puedo superar los 160 caracteres');        
    }
}
