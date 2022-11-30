<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchStoreRequest extends FormRequest
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
        return [
            'name' => 'required|max:70',
            'address' => 'required|max:70',
            'contact' => 'required|max:70',
            'city' => 'required|max:70'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'address' => 'Dirección',
            'contact' => 'Contacto',
            'city' => 'Ciudad'
        ];
    }
}
