@extends('layouts.main')

@section('title', 'Tambah Aktivitas Refleksi')

@section('content')
<div class="container-fluid"><br>
    <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Tambah Aktifitas Refleksi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('refleksi') }}">Refleksi Harian</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Tambah Aktifitas Refleksi</li>
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

    {{-- Menyisipkan form --}}
    @include('refleksi.form', [
        'route' => route('refleksi.store'),
        'method' => 'POST'
    ])
</div>
@endsection
