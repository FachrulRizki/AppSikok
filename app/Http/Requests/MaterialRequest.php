<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'type' => $this->isMethod('post') ? 'required|in:youtube,pdf' : 'nullable|in:youtube,pdf',
            'source' => $this->isMethod('post') ? 'required' : 'nullable',
            'content' => 'nullable|string',
        ];
    }
}
