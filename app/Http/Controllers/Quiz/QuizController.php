<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizRequest;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('kuis.list')) return abort(403);

        $search = $request->get('search');

        $data = Quiz::query();

        if ($search) {
            $data->where('title', 'like', '%' . $search . '%');
        }

        return view('quiz.index', [
            'data' => $data->latest()->paginate(10)
        ]);
    }

    public function store(QuizRequest $request)
    {
        if (!auth()->user()->can('kuis.buat')) return abort(403);

        $request->validated();

        $quiz = Quiz::create($request->all());

        return redirect()->route('quiz.edit', $quiz->id)->with('success', 'Kuis berhasil dibuat');
    }

    public function show(Quiz $quiz)
    {
        if (!auth()->user()->can('kuis.detail')) return abort(403);

        return view('quiz.show', [
            'quiz' => $quiz
        ]);
    }

    public function edit(Request $request,Quiz $quiz)
    {
        if (!auth()->user()->can('kuis.edit')) return abort(403);

        $question_id = $request->get('question');

        $question = null;

        if ($question_id) {
            $question = $quiz->questions()->where('id', $question_id)->first();
        }

        return view('quiz.edit', [
            'quiz' => $quiz,
            'question' => $question
        ]);
    }

    public function update(QuizRequest $request, Quiz $quiz)
    {
        if (!auth()->user()->can('kuis.edit')) return abort(403);

        $request->validated();

        $quiz->update($request->all());

        return redirect()->back()->with('success', 'Kuis berhasil diperbarui');
    }

    public function destroy(Quiz $quiz)
    {
        if (!auth()->user()->can('kuis.hapus')) return abort(403);

        $quiz->delete();

        return redirect()->route('quiz.index')->with('success', 'Kuis berhasil dihapus');   
    }
}
