@extends('layouts.main')

@section('title', 'Edit Materi')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/quill/dist/quill.snow.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Edit Materi</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('materi.index') }}">Materi</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Edit Materi</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="modernize-img"
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @include('materials.form', [
            'route' => route('materi.update', $material->id),
            'method' => 'PUT',
            'material' => $material
        ])
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/quill/dist/quill.min.js') }}"></script>
    <script>
        var quill = new Quill("#quill-editor", {
            theme: "snow",
        });

        var sourceInput = document.getElementById('source-input');
        var material = @json($material);

        document.getElementById('type-select').addEventListener('change', function() {
            var type = this.value;

            if (type === 'pdf') {
                sourceInput.type = 'file';
                sourceInput.accept = 'application/pdf';
            } else {
                sourceInput.type = 'text';
                sourceInput.removeAttribute('accept');
            }
        });

        const oldType = @json(old('type'));
        if (oldType == 'pdf'|| material.type == 'pdf') {
            sourceInput.type = 'file'
        } else {
            sourceInput.type = 'text'
        }

        const oldContent = @json(old('content'));
        if (oldContent) {
            quill.root.innerHTML = oldContent;
        } else if (material.content) {
            quill.root.innerHTML = material.content;
        }

        function syncQuillContent() {
            const quillHtml = quill.root.innerHTML;
            document.getElementById('quill-content').value = quillHtml;
            return true;
        }
    </script>
@endpush
