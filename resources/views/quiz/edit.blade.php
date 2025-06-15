@extends('layouts.main')

@section('title', 'Edit Kuis')

@section('content')
<div class="container-fluid">
    <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Edit Kuis</h4>
                    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('quiz.index') }}">Kuis</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Edit Kuis</li>
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

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Detail Kuis</h4>
                    <form action="{{ route('quiz.update', $quiz->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Judul Kuis</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $quiz->title ?? '') }}">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $quiz->description ?? '') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Daftar Pertanyaan</h4>
                        <form action="{{ route('question.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                            <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Pertanyaan"><i class="ti ti-plus"></i></button>
                        </form>
                    </div>
                    <div class="d-flex gap-2">
                    @forelse ($quiz->questions as $item)
                        <a href="{{ route('quiz.edit', [$quiz->id, 'question' => $item->id]) }}" class="btn w-10 {{ $item->id == request('question') ? 'btn-primary' : 'bg-primary-subtle text-primary' }}">{{ $loop->iteration }}</a>
                    @empty
                        <p class="mb-0 w-100 text-center">Belum ada pertanyaan</p>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Pertanyaan</h4>
                        @if ($question)
                            <div class="d-flex gap-2">
                                <form action="{{ route('question.destroy', $question->id) }}" method="post" onsubmit="return confirm('Yakin hapus pertanyaan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Pertanyaan"><i class="ti ti-trash"></i></button>
                                </form>
                                <button type="submit" form="question-form" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Simpan Pertanyaan"><i class="ti ti-check"></i></button>
                            </div>
                        @endif
                    </div>
                    @php
                        $existingOptions = $question->options ?? collect();
                        $optionLabels = range('A', 'Z');
                    @endphp
                    @if ($question)
                        <form action="{{ route('question.update', $question->id) }}" method="post" id="question-form">
                            @csrf
                            @method('PUT')
                            <div>
                                <textarea name="question_text" placeholder="Tulis pertanyaan..." rows="3" class="form-control @error('question_text') is-invalid @enderror" required>{{ old('question_text', $question->question_text ?? '') }}</textarea>
                                @error('question_text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <hr class="my-4">
                            <div id="option-container">
                                @php
                                    $oldOptions = old('options');
                                    $oldOptionIds = old('option_ids');
                                    $correctOption = old('correct_option', $question->correct_option);
                                @endphp
                                @if ($oldOptions)
                                    @foreach ($oldOptions as $label => $text)
                                        <div class="input-group mb-3 option-item">
                                            <span class="input-group-text">{{ $label }}</span>
                                            @if (isset($oldOptionIds[$label]))
                                                <input type="hidden" name="option_ids[{{ $label }}]" value="{{ $oldOptionIds[$label] }}">
                                            @endif
                                            <input type="text" name="options[{{ $label }}]" class="form-control" value="{{ $text }}" required>
                                            <input type="radio" name="correct_option" value="{{ $label }}" class="btn-check" id="correct{{ $label }}"
                                                {{ $label === $correctOption ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="correct{{ $label }}"><i class="ti ti-circle-check"></i></label>
                                            <button type="button" class="btn btn-danger remove-option"><i class="ti ti-trash"></i></button>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($question->options as $option)
                                        <div class="input-group mb-3 option-item">
                                            <span class="input-group-text">{{ $option->option_label }}</span>
                                            <input type="hidden" name="option_ids[{{ $option->option_label }}]" value="{{ $option->id }}">
                                            <input type="text" name="options[{{ $option->option_label }}]" class="form-control"
                                                value="{{ $option->option_text }}" required>
                                            <input type="radio" name="correct_option"
                                                value="{{ $option->option_label }}"
                                                class="btn-check"
                                                id="correct{{ $option->option_label }}"
                                                {{ $option->option_label === $correctOption ? 'checked' : '' }}
                                            >
                                            <label class="btn btn-outline-success" for="correct{{ $option->option_label }}"><i class="ti ti-circle-check"></i></label>
                                            <button type="button" class="btn btn-danger remove-option"><i class="ti ti-trash"></i></button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary" id="add-option">Tambah Pilihan</button>
                            </div>
                        </form>
                    @else
                        <p class="mb-0 text-center">Pilih pertanyaan lebih dahulu</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function(){
        let nextOptionCharCode = (() => {
            let labels = [...document.querySelectorAll('#option-container .input-group-text')]
                            .map(el => el.innerText.trim());
            if (labels.length === 0) return 'A'.charCodeAt(0);
            let last = labels[labels.length - 1];
            return last.charCodeAt(0) + 1;
        })();

        document.getElementById('add-option').addEventListener('click', function () {
            const container = document.getElementById('option-container');
            const optionChar = String.fromCharCode(nextOptionCharCode);

            const optionDiv = document.createElement('div');
            optionDiv.className = 'input-group mb-3 option-item';
            optionDiv.innerHTML = `
                <span class="input-group-text">${optionChar}</span>
                <input type="text" name="options[${optionChar}]" class="form-control" placeholder="Opsi ${optionChar}" required>
                <input type="radio" name="correct_option" value="${optionChar}" class="btn-check" id="correct${optionChar}">
                <label class="btn btn-outline-success" for="correct${optionChar}"><i class="ti ti-circle-check"></i></label>
                <button type="button" class="btn btn-danger remove-option"><i class="ti ti-trash"></i></button>
            `;

            container.appendChild(optionDiv);
            nextOptionCharCode++;
        });

        document.getElementById('option-container').addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.remove-option');
            if (removeBtn) {
                const row = removeBtn.closest('.option-item');
                if (row) row.remove();
            }
        });
    })
</script>
@endpush
