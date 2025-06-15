@extends('layouts.main')

@section('title', 'Detail Pengerjaan')

@section('content')
<div class="container-fluid">
    <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Detail Pengerjaan</h4>
                    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Detail Pengerjaan</li>
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

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Detail Kuis</h4>
                    <div class="table-responsive">
                        <table class="w-100 text-nowrap">
                            <tbody>
                                <tr>
                                    <th class="pb-2 text-start align-text-top">Judul Kuis</th>
                                    <td class="pb-2 text-end text-wrap">{{ $attempt->quiz->title }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2 text-start">Nama Peserta</th>
                                    <td class="py-2 text-end">{{ $attempt->user->name }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2 text-start">Nilai Akhir</th>
                                    <td class="py-2 text-end text-primary">{{ $attempt->score }}</td>
                                </tr>
                                <tr>
                                    <th class="pt-2 text-start">Dikerjakan pada</th>
                                    <td class="pt-2 text-end">{{ $attempt->created_at->format('d-m-Y, H:i') }} WIB</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Detail Jawaban</h4>
                    @foreach ($attempt->answers as $index => $answer)
                        <div class="border rounded p-3 mb-3">
                            <h5 class="mb-3 fs-4">{{ $index + 1 }}. {{ $answer->question->question_text }}</h5>
                            <div class="rounded p-2 {{ $answer->is_correct_option ? 'bg-success-subtle text-primary' : 'bg-danger-subtle text-danger' }}">
                                <p class="mb-0"><strong>Jawaban:</strong> {{ $answer->selected_option }}. {{ $answer->option }}</p>
                            </div>
                            @if (!$answer->is_correct_option)
                                <div class="rounded p-2 bg-success-subtle text-primary mt-2">
                                    <p class="mb-0"><strong>Jawaban benar:</strong> {{ $answer->correct_option->option_label }}. {{ $answer->correct_option->option_text }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
