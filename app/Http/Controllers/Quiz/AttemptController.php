<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\AttemptAnswer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $data = QuizAttempt::with('quiz', 'user')
            ->where('user_id', auth()->user()->id);

        if ($search) {
            $data->whereHas('quiz', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            });
        }

        return view('attempt.index', [
            'data' => $data->latest()->paginate(10)
        ]);
    }

    public function create(Request $request)
    {
        $quiz_id = $request->get('quiz_id');

        if ($quiz_id) {

            if (!auth()->user()->can('kuis.mengerjakan') || auth()->user()->answers()->where('quiz_id', $quiz_id)->exists()) {
                return abort(403);
            }

            $quiz = Quiz::with('questions.options')->find($quiz_id);

            return view('attempt.create', [
                'quiz' => $quiz
            ]);
        }
    }

    public function store(Request $request)
    {
        $quiz_id = $request->get('quiz_id');

        if ($quiz_id) {
            if (!auth()->user()->can('kuis.mengerjakan') || auth()->user()->answers()->where('quiz_id', $quiz_id)->exists()) {
                return abort(403);
            }

            $questions = Question::where('quiz_id', $quiz_id)
                ->with('options')
                ->get();

            $score = 0;
            $total = $questions->count();
            $answers = $request->input('answers', []);
            
            foreach ($questions as $question) {
                $correct = $question->correct_option;
                if (isset($answers[$question->id]) && $answers[$question->id] == $correct) {
                    $score++;
                }
            }

            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz_id,
                'user_id' => auth()->user()->id,
                'score' => (100/$total) * $score,
            ]);

            foreach ($answers as $questionId => $selectedOption) {
                AttemptAnswer::create([
                    'quiz_attempt_id' => $attempt->id,
                    'question_id' => $questionId,
                    'selected_option' => $selectedOption
                ]);
            }

            activity()
                ->event('Buat Data')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mengerjakan Kuis');

            return redirect()->route('attempt.show', $attempt->id)->with('success', 'Pengerjaan kuis berhasil disimpan.');
        }
    }

    public function show(QuizAttempt $attempt)
    {
        return view('attempt.show', [
            'attempt' => $attempt
        ]);
    }

    public function destroy(QuizAttempt $attempt)
    {
        if (!auth()->user()->can('kuis.hapus')) return abort(403);
        
        $attempt->delete();

        activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Riwayat Pengerjaan Kuis');

        return redirect()->back()->with('success', 'Pengerjaan kuis berhasil dihapus.');
    }

    public function export(Request $request)
    {
        if (!auth()->user()->can('kuis.export')) return abort(403);

        $quiz_id = $request->get('quiz_id');

        if ($quiz_id) {
            $data = QuizAttempt::select('quiz_id', 'user_id', 'score', 'created_at')
                ->where('quiz_id', $quiz_id)
                ->with('user', 'quiz')
                ->latest()
                ->get();

            $quiz = Quiz::find($quiz_id);

            // return view('quiz.export', compact('data', 'quiz'));

            $pdf = Pdf::loadView('quiz.export', compact('data', 'quiz'))->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])->setPaper('a4', 'portrait');

            activity()
                ->event('Export Data')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mengexport pengerjaan kuis');

            return $pdf->download('Pengerjaan Kuis - '. $quiz->title . '.pdf');
        }
    }
}
