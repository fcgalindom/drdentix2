<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DentistStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->id == 0) {
            $rules['password'] = 'required|min:8|max:50';
            $rules['confPassword'] = 'required|same:password';
        }
        $rules = [
            'name' => 'required|max:70',
            'city' => 'required|max:70',
            'document' => 'required|integer|unique:users,document,' . $this->id_user,
        ];
        if (!empty($this->email)) :
            $rules['email'] = 'required|email|unique:users,email,' . $this->id_user;
        endif;

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'city' => 'Ciudad',
            'document' => 'Documento',
            'email' => 'Correo',
            'password' => 'Contraseña',
            'confPassword' => 'Confirmar contraseña'
        ];
    }
}
