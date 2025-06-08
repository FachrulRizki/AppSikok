<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefleksiRequest extends FormRequest
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
            'jdl_kegiatan' => 'required|string|max:255',
            'poin_materi' => 'nullable|string',
            'pribadi' => 'nullable|string',
            'tindakan' => 'nullable|string',
        ];
    }
}
