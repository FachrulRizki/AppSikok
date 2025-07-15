<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->user()->can('kuis.buat')) return abort(403);

        $request->validate(['quiz_id' => 'required|exists:quizzes,id']);

        $question = Question::create([
            'quiz_id' => $request->quiz_id,
        ]);

        activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Soal Kuis');

        return redirect()->route('quiz.edit', [
            'quiz' => $question->quiz_id,
            'question' => $question->id
        ]);
    }

    public function update(Request $request, Question $question)
    {
        if (!auth()->user()->can('kuis.edit')) return abort(403);

        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'correct_option' => 'required|in:' . implode(',', array_keys($request->input('options', []))),
        ], [
            'question_text.required' => 'Pertanyaan harus diisi',
            'options.required' => 'Pilihan jawaban harus dibuat',
            'options.min' => 'Pilihan jawaban harus memiliki minimal 2 opsi',
            'correct_option.required' => 'Jawaban benar harus dipilih',
            'correct_option.in' => 'Jawaban benar harus salah satu opsi yang ada',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'correct_option' => $request->correct_option,
        ]);

        foreach ($request->options as $label => $text) {
            if (isset($request->option_ids[$label])) {
                Option::where('id', $request->option_ids[$label])->update([
                    'option_text' => $text,
                    'option_label' => $label
                ]);
            } else {
                if (!empty($text)) {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $text,
                        'option_label' => $label
                    ]);
                }
            }
        }

        // Delete opsi yang tidak dikirim
        $labelsToKeep = array_keys($request->options);
        $question->options()->whereNotIn('option_label', $labelsToKeep)->delete();

        activity()
            ->event('Update Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengupdate Soal Kuis');

        return redirect()->back()->with('success', 'Pertanyaan berhasil diperbarui');
    }

    public function destroy(Question $question)
    {
        if (!auth()->user()->can('kuis.edit')) return abort(403);

        $question->delete();

        activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Soal Kuis');

        return redirect()->route('quiz.edit', $question->quiz_id)->with('success', 'Pertanyaan berhasil dihapus');
    }
}
