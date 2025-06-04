@extends('layouts.main')

@section('title', 'Edit Aktivitas Supervisi')

@section('content')
<div class="container-fluid">
    <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Edit Aktifitas Supervisi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('refleksi') }}">Supervisi Kepala Ruang</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Edit Aktifitas Supervisi</li>
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

    @include('spv_kepru.form', [
        'route' => route('spv_kepru.update', $spv_kepru->id),
        'method' => 'PUT',
        'spv_kepru' => $spv_kepru
    ])
</div>
@endsection
