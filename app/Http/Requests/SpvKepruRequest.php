<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpvKepruRequest extends FormRequest
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
            'waktu' => 'required|date',
            'ruangan' => 'required|string|max:255',
            'shift' => 'required|string|in:Pagi,Sore,Malam',
            'aktivitas' => 'required|array',
            'observasi' => 'nullable|string',
            'perbaikan' => 'nullable|string',
        ];
    }
}
