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
        $id = $this->route('user')?->id;

        return [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,' . $id,
            'password' => $this->isMethod('post') ? 'required|min:8|confirmed' : 'nullable|min:8|confirmed',
            'unit' => 'nullable|max:255',
            'role' => 'required',
        ];
    }
}
