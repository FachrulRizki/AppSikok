@extends('layouts.main')

@section('title', 'Tambah Sertifikat')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Tambah Sertifikat</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none"
                                        href="{{ route('sertifikat.index') }}">Sertifikat</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Tambah Sertifikat</li>
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

        <h1>Unggah Sertifikat</h1>

        <form action="{{ route('sertifikat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file_pdf" required>
            <button type="submit">Unggah</button>
        </form>

        @error('file_pdf')
            <p>{{ $message }}</p>
        @enderror
    </div>
@endsection
