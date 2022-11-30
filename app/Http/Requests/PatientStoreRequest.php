<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientStoreRequest extends FormRequest
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
        if (!empty($this->email)) $rules['email'] = 'required|email|unique:users,email,' . $this->id_user;
        $rules = [
            'name' => 'required|max:255',
            'telephone' => 'required|integer',
            'document' => 'required|integer|unique:users,document,' . $this->id_user
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'telephone' => 'Teléfono',
            'document' => 'Documento'
        ];
    }
}
