<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AktivitasKeperawatanRequest extends FormRequest
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
            'shift' => 'required|string|in:Pagi,Sore,Malam',
            'selectedActivities' => 'required|string',
            'selectedDetails' => 'required|string',
            'selectedTasks' => 'required|string',
            'notes' => 'nullable|string',
            'catatan' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'waktu.required' => 'Tanggal & waktu harus diisi',
            'waktu.date' => 'Tanggal & waktu harus diisi dengan format yang benar',
            'shift.required' => 'Shift harus diisi',
            'shift.in' => 'Shift harus diisi dengan Pagi, Sore, atau Malam',
            'selectedActivities.required' => 'Aktivitas harus diisi',
            'selectedDetails.required' => 'Detail aktivitas harus diisi',
            'selectedTasks.required' => 'Tugas harus diisi',
            'notes.string' => 'Catatan harus diisi dengan format string',
            'catatan.string' => 'Catatan harus diisi dengan format string',
        ];
    }
}
