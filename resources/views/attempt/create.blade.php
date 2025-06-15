@extends('layouts.main')

@section('title', 'Pengerjaan Kuis')

@section('content')
<div class="container-fluid">
    <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pengerjaan Kuis</h4>
                    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('quiz.index') }}">Kuis</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Pengerjaan Kuis</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h1 class="fs-6 fw-semibold">{{ $quiz->title }}</h1>
            <p class="mb-0">{{ $quiz->description }}</p>
        </div>
    </div>
    <form action="{{ route('attempt.store', ['quiz_id' => $quiz->id]) }}" method="post">
        @csrf
        @foreach ($quiz->questions as $index => $question)
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3 fs-4">{{ $index + 1 }}. {{ $question->question_text }}</h5>
                    @foreach ($question->options as $option)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="q{{ $question->id }}{{ $option->option_label }}" value="{{ $option->option_label }}" required>
                            <label class="form-check-label" for="q{{ $question->id }}{{ $option->option_label }}">
                                <strong>{{ $option->option_label }}.</strong> {{ $option->option_text }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary mb-5 float-end">Selesai</button>
    </form>
</div>
@endsection
